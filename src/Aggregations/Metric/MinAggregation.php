<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Aggregations\Metric;

class MinAggregation extends StatsAggregation
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'min';
    }
}
