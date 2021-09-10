<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Span;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 通过搜索字段，允许跨度查询参与复合单字段跨度查询的包装器。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-field-masking-query.html
 */
class SpanNearQuery extends Query
{

    protected array $clauses = [];

    public function getName(): string
    {
       return 'span_near';
    }

    public function toArray(): array
    {
        return [];
    }
}
