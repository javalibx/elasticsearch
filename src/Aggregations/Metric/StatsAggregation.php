<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Aggregations\Metric;

use Kabunx\Elasticsearch\Aggregations\Aggregation;

/**
 * Class StatsAggregation
 * @package Kabunx\Elasticsearch\Aggregations\Metric
 */
class StatsAggregation extends Aggregation
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'stats';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $output = [
            'field' => $this->field
        ];
        if ($this->scripts) {
            $output['script'] = $this->scripts;
        }

        return $output;
    }
}
