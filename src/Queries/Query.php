<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries;

use Kabunx\Elasticsearch\Contracts\QueryInterface;
use Kabunx\Elasticsearch\HasParams;

/**
 * Class Query
 * @package Kabunx\Elasticsearch\Queries
 */
abstract class Query implements QueryInterface
{
    use HasParams;

    /**
     * @var mixed
     */
    protected mixed $value;

    /**
     * @var string
     */
    protected string $field;

    /**
     * 只有在复合查询下才能合并
     *
     * @var bool
     */
    protected bool $multiple = false;

    /**
     * Query constructor.
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->setParams($params);
    }

    /**
     * @param array $params
     * @return static
     */
    public static function make(array $params = []): static
    {
        return new static($params);
    }

    /**
     * @return array
     */
    public function body(): array
    {
        return [
            $this->getName() => $this->toArray()
        ];
    }

    /**
     * @param string $field
     * @return $this
     */
    public function setField(string $field): static
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    /**
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple(bool $multiple): static
    {
        $this->multiple = $multiple;

        return $this;
    }


}
