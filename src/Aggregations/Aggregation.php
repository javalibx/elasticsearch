<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Aggregations;

use Kabunx\Elasticsearch\Contracts\AggregationInterface;
use Kabunx\Elasticsearch\HasParams;

/**
 * Class Aggregation
 * @package Kabunx\Elasticsearch\Aggregations
 */
abstract class Aggregation implements AggregationInterface
{
    use HasParams;

    /**
     * @var array
     */
    protected array $scripts = [];

    /**
     * @var bool
     */
    protected bool $nesting = false;

    /**
     * @var string
     */
    protected string $field;

    /**
     * @var string
     */
    protected string $as;

    /**
     * @return array
     */
    abstract public function toArray(): array;

    /**
     * @return array
     */
    public function body(): array
    {
        return [
            $this->as => [
                $this->getName() => $this->toArray()
            ],
        ];
    }

    /**
     * @param string $field
     * @return $this
     */
    public function setField(string $field): static
    {
        $this->field = $field;
        $this->as = $field . '_' . $this->getName();

        return $this;
    }

    /**
     * @return string
     */
    public function getAs(): string
    {
        return $this->as;
    }


}
