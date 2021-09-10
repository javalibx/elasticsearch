<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Fulltext;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 查询支持搜索多个文本字段，就好像它们的内容已被索引到一个组合字段中一样。
 * 它采用以术语为中心的查询视图：首先将查询字符串分析为单独的术语，然后在任何字段中查找每个术语。
 * 当匹配可以跨越多个文本字段时，此查询特别有用，例如文章的标题、摘要和正文
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-combined-fields-query.html
 */
class CombinedFieldsQuery extends Query
{
    /**
     * @var array
     */
    protected array $fields = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'combined_fields';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->merge([
            'query' => (string)$this->value,
            'fields' => $this->fields
        ]);
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

}
