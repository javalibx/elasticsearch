<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Fulltext;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 返回与提供的文本、数字、日期或布尔值匹配的文档。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query.html
 */
class MatchQuery extends Query
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'match';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            $this->field => $this->merge([
                'query' => $this->value
            ]),
        ];
    }
}
