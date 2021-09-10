<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Contracts;

/**
 * Interface EndpointInterface
 * @package Kabunx\Elasticsearch\Contracts
 */
interface EndpointInterface
{

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return array
     */
    public function toArray(): array;

}
