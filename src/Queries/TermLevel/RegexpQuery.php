<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\TermLevel;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 返回包含与正则表达式匹配的术语的文档。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-regexp-query.html
 */
class RegexpQuery extends Query
{

    protected string $flags;

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'regexp';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->merge([
            'value' => (string)$this->value,
        ]);
    }
}
