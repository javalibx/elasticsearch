<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Contracts;

/**
 * Interface AggregationInterface
 * @package Kabunx\Elasticsearch\Contracts
 */
interface AggregationInterface
{

    public function getName(): string;

    public function toArray(): array;

    public function body(): array;
}
