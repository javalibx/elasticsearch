<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Fulltext;

/**
 * 使用具有有限但容错语法的解析器，根据提供的查询字符串返回文档。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-simple-query-string-query.html
 */
class SimpleQueryStringQuery extends QueryStringQuery
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'simple_query_string';
    }
}
