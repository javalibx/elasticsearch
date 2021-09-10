<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Compound;

use Kabunx\Elasticsearch\Contracts\CompoundQueryInterface;
use Kabunx\Elasticsearch\Contracts\QueryInterface;
use Kabunx\Elasticsearch\Queries\Query;

/**
 * 返回匹配一个或多个包装查询的文档，称为查询子句或子句。
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-dis-max-query.html
 */
class DisMaxQuery extends Query implements CompoundQueryInterface
{

    /**
     * （必需，查询对象数组）包含一个或多个查询子句。
     * 返回的文档必须与这些查询中的一个或多个匹配。
     * 如果一个文档匹配多个查询，Elasticsearch 使用最高的相关性分数。
     *
     * @var array
     */
    protected array $queries = [];

    /**
     * (可选，浮点数) 0 到 1.0 之间的浮点数，
     * 用于增加匹配多个查询子句的文档的相关性分数。
     *
     * @var float
     */
    protected float $tieBreaker = 0.0;

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'dis_max';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $queries = [];
        foreach ($this->queries as $query) {
            if ($query instanceof QueryInterface) {
                $queries[] = $query->body();
            }
        }

        return $this->merge([
            'queries' => $queries,
            'tie_breaker' => $this->tieBreaker
        ]);
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

    /**
     * @return float
     */
    public function getTieBreaker(): float
    {
        return $this->tieBreaker;
    }

}
