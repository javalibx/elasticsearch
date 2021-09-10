<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Sorts;

use Kabunx\Elasticsearch\Contracts\QueryInterface;

/**
 * Class NestedSort
 * @package Kabunx\Elasticsearch\Sorts
 */
class NestedSort extends Sort
{

    /**
     * @var QueryInterface
     */
    protected QueryInterface $filter;

    /**
     * @var QueryInterface
     */
    protected QueryInterface $nestedFilter;

    /**
     * @return array
     */
    public function toArray(): array
    {
        $output = [
            'path' => $this->column,
        ];
        if (isset($this->filter)) {
            $output['filter'] = $this->filter->toArray();
        }
        if (isset($this->nestedFilter)) {
            $output['nested'] = $this->nestedFilter->toArray();
        }

        return $this->merge($output);
    }

    /**
     * @param QueryInterface $filter
     * @return $this
     */
    public function setFilter(QueryInterface $filter): static
    {
        $this->filter = $filter;

        return $this;
    }


    /**
     * @param QueryInterface $nestedFilter
     * @return $this
     */
    public function setNestedFilter(QueryInterface $nestedFilter): static
    {
        $this->nestedFilter = $nestedFilter;

        return $this;
    }


}
