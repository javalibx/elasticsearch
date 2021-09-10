<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Compound;

use Kabunx\Elasticsearch\Contracts\CompoundQueryInterface;
use Kabunx\Elasticsearch\Contracts\QueryInterface;
use Kabunx\Elasticsearch\Queries\Query;
use stdClass;

/**
 * 匹配与其他查询的布尔组合匹配的文档的查询。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-bool-query.html
 */
class BoolQuery extends Query implements CompoundQueryInterface
{

    public const MUST_QUERY = 'must';

    public const SHOULD_QUERY = 'should';

    public const MUST_NOT_QUERY = 'must_not';

    public const FILTER_QUERY = 'filter';

    /**
     * @var QueryInterface[][]
     */
    protected array $typeQueries = [];

    /**
     * @var float
     */
    protected float $boost = 1.0;

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'bool';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [];
        foreach ($this->typeQueries as $type => $queries) {
            foreach ($queries as $query) {
                if ($query instanceof QueryInterface) {
                    $result[$type][] = $query->body();
                }
            }
        }

        return $this->merge($result);
    }

    /**
     * @return array
     */
    public function body(): array
    {
        $output = $this->toArray();

        return [
            $this->getName() => $output ?: new stdClass()
        ];
    }

    /**
     * @return QueryInterface[][]
     */
    public function getTypeQueries(): array
    {
        return $this->typeQueries;
    }


    /**
     * @param QueryInterface $query
     * @param string $type
     * @return $this
     */
    public function addQuery(QueryInterface $query, string $type): static
    {
        if ($this->isValidType($type)) {
            if ($this->isShouldType($type)) {
                $this->setMinimumShouldMatch();
            }
            $this->typeQueries[$type][] = $query;
        }

        return $this;
    }

    /**
     * @param string $pType
     * @return QueryInterface|null
     */
    public function getCrossedQuery(string $pType): ?QueryInterface
    {
        $types = array_keys($this->typeQueries);
        // including multiple types cannot be crossed
        if (count($types) > 1) {
            return null;
        }
        $type = $types[0];
        if (! in_array($type, [$pType, static::MUST_QUERY])) {
            return null;
        }
        // including multiple queries cannot be crossed
        $tQueries = $this->typeQueries[$type];
        if (count($tQueries) > 1) {
            return null;
        }
        $query = $tQueries[0];

        return $query instanceof BoolQuery
            ? $query->getCrossedQuery($pType)
            : $query;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return count($this->typeQueries) == 0;
    }

    /**
     * @param float $boost
     * @return $this
     */
    public function setBoost(float $boost): static
    {
        $this->boost = $boost;
        $this->addParam('boost', $this->boost);

        return $this;
    }

    /**
     * @param int $minimumShouldMatch
     * @return $this
     */
    public function setMinimumShouldMatch(int $minimumShouldMatch = 1): static
    {
        $this->addParam('minimum_should_match', $minimumShouldMatch);

        return $this;
    }

    /**
     * @param string $type
     * @return bool
     */
    protected function isValidType(string $type): bool
    {
        return in_array($type, [
            self::MUST_QUERY, self::SHOULD_QUERY, self::MUST_NOT_QUERY, self::FILTER_QUERY
        ]);
    }

    /**
     * @param string $type
     * @return bool
     */
    protected function isShouldType(string $type): bool
    {
        return $type == static::SHOULD_QUERY;
    }
}
