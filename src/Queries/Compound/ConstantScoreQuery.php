<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Compound;

use Kabunx\Elasticsearch\Contracts\CompoundQueryInterface;
use Kabunx\Elasticsearch\Contracts\QueryInterface;
use Kabunx\Elasticsearch\Queries\Query;

/**
 * 包装过滤器查询并返回相关性分数等于 boost 参数值的每个匹配文档。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-constant-score-query.html
 */
class ConstantScoreQuery extends Query implements CompoundQueryInterface
{
    /**
     * 必须的，
     * @var array
     */
    protected array $queries = [];

    /**
     * （可选），用作与过滤器查询匹配的每个文档的恒定相关性分数的浮点数。
     *
     * @var float
     */
    protected float $boost = 1.0;

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'constant_score';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $filter = [];
        foreach ($this->queries as $query) {
            if ($query instanceof QueryInterface) {
                $output[] = $query->body();
            }
        }

        return $this->merge([
            'filter' => $filter,
            'boost' => $this->boost
        ]);
    }

    /**
     * @param float $boost
     * @return $this
     */
    public function setBoost(float $boost): static
    {
        $this->boost = $boost;

        return $this;
    }


    /**
     * @param QueryInterface $query
     * @return $this
     */
    public function addQuery(QueryInterface $query): static
    {
        $this->queries[] = $query;

        return $this;
    }
}
