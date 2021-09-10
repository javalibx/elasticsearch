<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Fulltext;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 使用具有严格语法的解析器根据提供的查询字符串返回文档。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-query-string-query.html
 */
class QueryStringQuery extends Query
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
        return 'query_string';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->merge([
            'query' => (string)$this->value,
            'fields' => $this->getFields()
        ]);
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields ?: [$this->field];
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

}
