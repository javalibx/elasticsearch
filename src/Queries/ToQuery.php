<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries;

use Kabunx\Elasticsearch\Contracts\QueryInterface;
use Kabunx\Elasticsearch\Queries\Compound\BoolQuery;
use Kabunx\Elasticsearch\Queries\Fulltext\MatchQuery;
use Kabunx\Elasticsearch\Queries\TermLevel\ExistsQuery;
use Kabunx\Elasticsearch\Queries\TermLevel\IdsQuery;
use Kabunx\Elasticsearch\Queries\TermLevel\RangeQuery;
use Kabunx\Elasticsearch\Queries\TermLevel\TermQuery;
use Kabunx\Elasticsearch\Queries\TermLevel\TermsQuery;
use Kabunx\Elasticsearch\Queries\TermLevel\WildcardQuery;

trait ToQuery
{

    /**
     * @param string $field
     * @param string $operator
     * @param mixed $value
     * @param array $params
     * @return $this
     */
    public function where(string $field, string $operator, mixed $value, array $params = []): static
    {
        $query = $this->guessQuery($field, $operator, $value, $params);
        $type = in_array($operator, ['<>', '!=']) ? BoolQuery::MUST_NOT_QUERY : BoolQuery::MUST_QUERY;

        return $this->addQuery($query, $type);
    }

    /**
     * @param array $ids
     * @return $this
     */
    public function ids(array $ids): static
    {
        return $this->addQuery(
            (new IdsQuery())->setValue($ids)
        );
    }

    /**
     * @param string $field
     * @param array $params
     * @return $this
     */
    public function exists(string $field, array $params = []): static
    {
        return $this->addQuery(
            (new ExistsQuery($params))->setField($field),
        );
    }

    /**
     * @param string $field
     * @param array $values
     * @param array $params
     * @return $this
     */
    public function terms(string $field, array $values, array $params = []): static
    {
        return $this->addQuery(
            (new TermsQuery($params))->setField($field)->setValue($values)
        );
    }

    /**
     * @param string $field
     * @param int|float $min
     * @param int|float $max
     * @param array $params
     * @return $this
     */
    public function between(string $field, int|float $min, int|float $max, array $params = []): static
    {
        return $this->addQuery(
            (new RangeQuery($params))->setField($field)->setGteValue($min)->setLteValue($max)
        );
    }

    /**
     * @param string $field
     * @param string $operator
     * @param mixed $value
     * @param array $params
     * @return QueryInterface
     */
    public function guessQuery(string $field, string $operator, mixed $value, array $params): QueryInterface
    {
        $query = match ($operator) {
            '=', '!=', '<>' => new TermQuery($params),
            '>' => (new RangeQuery($params))->setGtValue($value),
            '<' => (new RangeQuery($params))->setLtValue($value),
            '>=' => (new RangeQuery($params))->setGteValue($value),
            '<=' => (new RangeQuery($params))->setLteValue($value),
            'match' => (new MatchQuery($params))->setValue($value),
            'like', 'wildcard' => new WildcardQuery($params),
            default => new NullQuery(),
        };

        return $query->setField($field)->setValue($value);
    }
}
