<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Aggregations\Metric;

class AvgAggregation extends StatsAggregation
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'avg';
    }

}
