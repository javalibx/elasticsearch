<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Aggregations\Metric;

class MaxAggregation extends StatsAggregation
{

    public function getName(): string
    {
        return 'max';
    }
}
