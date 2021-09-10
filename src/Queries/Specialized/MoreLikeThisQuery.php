<?php
declare(strict_types=1);
namespace Kabunx\Elasticsearch\Queries\Specialized;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 查找与给定文档集“相似”的文档。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-mlt-query.html
 */
class MoreLikeThisQuery extends Query
{
    /**
     * @var array
     */
    protected array $fields = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'more_like_this';
    }

    public function toArray(): array
    {
        return [];
    }
}
