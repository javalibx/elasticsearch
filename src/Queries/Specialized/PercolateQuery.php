<?php
declare(strict_types=1);
namespace Kabunx\Elasticsearch\Queries\Specialized;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-percolate-query.html#query-dsl-percolate-query
 */
class PercolateQuery extends Query
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'percolate';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'field' => $this->field
        ];
    }
}
