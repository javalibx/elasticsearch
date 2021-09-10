<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\TermLevel;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 根据文档的"ID"返回文档。此查询使用存储在"_id"字段中的文档。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-ids-query.html
 */
class IdsQuery extends Query
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ids';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->merge([
            'values' => (array)$this->value,
        ]);
    }
}
