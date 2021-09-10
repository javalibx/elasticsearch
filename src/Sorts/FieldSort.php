<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Sorts;

/**
 * Class FieldSort
 * @package Kabunx\Elasticsearch\Sorts
 */
class FieldSort extends Sort
{

    /**
     * @var string
     */
    protected string $direction = 'asc';

    /**
     * @return array
     */
    public function toArray(): array
    {
        $this->addParam('order', $this->direction);

        return [
            $this->column => $this->params,
        ];
    }

    /**
     * @param string $direction
     * @return $this
     */
    public function setDirection(string $direction): static
    {
        $this->direction = $direction;

        return $this;
    }

}
