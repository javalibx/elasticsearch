<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Compound;

use Kabunx\Elasticsearch\Contracts\CompoundQueryInterface;
use Kabunx\Elasticsearch\Queries\Query;

/**
 * 可以使用提升查询来降级某些文档而不将它们从搜索结果中排除。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-boosting-query.html
 */
class BoostingQuery extends Query implements CompoundQueryInterface
{

    /**
     * 必须的，任何返回的文档都必须与此查询匹配。
     *
     * @var array
     */
    protected array $positive;

    /**
     * 必须的，用于降低匹配文档的相关性分数的查询
     *
     * @var array
     */
    protected array $negative;

    /**
     * 必须的，0 到 1.0 之间的浮点数用于降低与否定查询匹配的文档的相关性分数
     *
     * @var float
     */
    protected float $boost = 0.0;

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'boosting';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }

}
