<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries;

/**
 * Class NullQuery
 * @package Kabunx\Elasticsearch\Queries
 */
class NullQuery extends Query
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
