<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\TermLevel;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 返回在提供的字段中包含特定前缀的文档。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-prefix-query.html
 */
class PrefixQuery extends Query
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'prefix';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            $this->field => $this->merge([
                'value' => $this->value,
            ]),
        ];
    }
}
