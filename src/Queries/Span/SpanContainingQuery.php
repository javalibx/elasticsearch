<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Span;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-containing-query.html
 */
class SpanContainingQuery extends Query
{

    public function getName(): string
    {
        return 'span_containing';
    }

    public function toArray(): array
    {
        return [];
    }
}
