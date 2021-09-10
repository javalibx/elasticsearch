<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\TermLevel;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 返回包含字段索引值的文档。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-exists-query.html
 */
class ExistsQuery extends Query
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'exists';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'field' => $this->field
        ];
    }
}
