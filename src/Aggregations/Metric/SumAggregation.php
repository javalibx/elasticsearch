<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Aggregations\Metric;

/**
 * Class SumAggregation
 * @package Kabunx\Elasticsearch\Aggregations\Metric
 */
class SumAggregation extends StatsAggregation
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'sum';
    }
}
