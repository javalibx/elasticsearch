<?php
declare(strict_types=1);
namespace Kabunx\Elasticsearch\Queries\Fulltext;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-intervals-query.html
 */
class IntervalsQuery extends Query
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'intervals';
    }

    public function toArray(): array
    {
        return [];
    }
}
