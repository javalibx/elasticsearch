<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Endpoints;

use Kabunx\Elasticsearch\Contracts\EndpointInterface;
use Kabunx\Elasticsearch\Contracts\SortInterface;
use Kabunx\Elasticsearch\Sorts\FieldSort;
use Kabunx\Elasticsearch\Sorts\ScriptSort;

class SortEndpoint implements EndpointInterface
{

    /**
     * @var array
     */
    protected array $sorts = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'sort';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $output = [];
        foreach ($this->sorts as $sort) {
            if ($sort instanceof SortInterface) {
                $output[] = $sort->toArray();
            }
        }

        return $output;
    }

    /**
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function addFieldSort(string $column, string $direction = 'asc'): static
    {
        $this->sorts[] = (new FieldSort())->setColumn($column)->setDirection($direction);

        return $this;
    }

    /**
     * @return $this
     */
    public function addNestedSort(): static
    {
        return $this;
    }

    /**
     * @param string $script
     * @return $this
     */
    public function withScriptSort(string $script): static
    {
        $this->sorts[] = (new ScriptSort())->setScript($script);

        return $this;
    }


    /**
     * @return $this
     */
    public function withRandomSort(): static
    {
        $this->sorts[] = (new ScriptSort())->random();

        return $this;
    }

}
