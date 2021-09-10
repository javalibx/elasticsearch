<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch;

trait HasParams
{
    /**
     * @var array
     */
    protected array $params = [];

    /**
     * @param array $arrays
     * @return array
     */
    public function merge(array ...$arrays): array
    {
        return array_merge($this->params, ...$arrays);
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params): static
    {
        $this->params = $params;

        return $this;
    }


    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function addParam(string $key, mixed $value): static
    {
        $this->params[$key] = $value;

        return $this;
    }
}
