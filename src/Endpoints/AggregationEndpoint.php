<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Endpoints;

use Kabunx\Elasticsearch\Aggregations\Metric\AvgAggregation;
use Kabunx\Elasticsearch\Aggregations\Metric\MaxAggregation;
use Kabunx\Elasticsearch\Aggregations\Metric\MinAggregation;
use Kabunx\Elasticsearch\Aggregations\Metric\StatsAggregation;
use Kabunx\Elasticsearch\Aggregations\Metric\SumAggregation;
use Kabunx\Elasticsearch\Aggregations\NullAggregation;
use Kabunx\Elasticsearch\Contracts\AggregationInterface;
use Kabunx\Elasticsearch\Contracts\EndpointInterface;

class AggregationEndpoint implements EndpointInterface
{

    /**
     * @var array
     */
    protected array $aggregations = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'aggregations';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $output = [];
        foreach ($this->aggregations as $aggregation) {
            if ($aggregation instanceof AggregationInterface) {
                $output[] = $aggregation->body();
            }
        }

        return array_filter($output);
    }

    /**
     * @param AggregationInterface $aggregation
     * @return $this
     */
    public function addAggregation(AggregationInterface $aggregation): static
    {
        $this->aggregations[] = $aggregation;

        return $this;
    }

    /**
     * @param string $field
     * @return $this
     */
    public function sum(string $field): static
    {
        return $this->addAggregation(
            (new SumAggregation())->setField($field)
        );
    }

    /**
     * @param string $field
     * @param string $type
     * @return AggregationInterface
     */
    protected function guessAggregation(string $field, string $type): AggregationInterface
    {
        $aggregation = match ($type) {
            'stats' => new StatsAggregation(),
            'sum' => new SumAggregation(),
            'min' => new MinAggregation(),
            'max' => new MaxAggregation(),
            'avg' => new AvgAggregation(),
            default => new NullAggregation()
        };

        return $aggregation->setField($field);
    }
}
