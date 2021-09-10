<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\TermLevel;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 返回包含提供范围内的术语的文档。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-range-query.html
 */
class RangeQuery extends Query
{
    public const LT = 'lt';
    public const GT = 'gt';
    public const LTE = 'lte';
    public const GTE = 'gte';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'range';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [$this->field => $this->params];
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setLtValue(mixed $value): static
    {
        $this->addParam(self::LT, $value);

        return $this;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setLteValue(mixed $value): static
    {
        $this->addParam(self::LTE, $value);

        return $this;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setGtValue(mixed $value): static
    {
        $this->addParam(self::GT, $value);

        return $this;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setGteValue(mixed $value): static
    {
        $this->addParam(self::GTE, $value);

        return $this;
    }
}
