<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\TermLevel;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 返回包含匹配通配符模式的术语的文档。
 * ?, 匹配任何单个字符
 * *, 可以匹配零个或多个字符，包括空字符
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-wildcard-query.html
 */
class WildcardQuery extends Query
{

    /**
     * @var float
     */
    protected float $boost = 1.0;

    /**
     * @var string
     */
    protected string $rewrite;

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'wildcard';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            $this->field => $this->merge([
                'value' => $this->formatValue($this->value)
            ])
        ];
    }

    /**
     * @param float $boost
     * @return $this
     */
    public function setBoost(float $boost): static
    {
        $this->boost = $boost;
        $this->addParam('boost', $boost);

        return $this;
    }

    /**
     * @param string $rewrite
     * @return $this
     */
    public function setRewrite(string $rewrite): static
    {
        $this->rewrite = $rewrite;
        $this->addParam('rewrite', $rewrite);

        return $this;
    }


    /**
     * @param string $value
     * @return string
     */
    protected function formatValue(string $value): string
    {
        return $this->isMatchedValue($value) ? $value : '*' . $value . '*';
    }

    /**
     * @param string $value
     * @return bool
     */
    protected function isMatchedValue(string $value): bool
    {
        return str_starts_with($value, '*') && str_ends_with($value, '*');
    }

}
