<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Aggregations;

class NullAggregation extends Aggregation
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return '';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }
}
