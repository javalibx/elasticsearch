<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Sorts;

use Kabunx\Elasticsearch\Contracts\SortInterface;
use Kabunx\Elasticsearch\HasParams;

/**
 * Class Sort
 * @package Kabunx\Elasticsearch\Sorts
 */
abstract class Sort implements SortInterface
{
    use HasParams;

    /**
     * @var string
     */
    protected string $column;

    /**
     * Sort constructor.
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->setParams($params);
    }

    /**
     * @param string $column
     * @return $this
     */
    public function setColumn(string $column): static
    {
        $this->column = $column;

        return $this;
    }

}
