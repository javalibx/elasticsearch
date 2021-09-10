<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Fulltext;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 查询分析其输入并根据术语构建 bool 查询。
 * 除了最后一个术语之外的每个术语都用于术语查询。最后一项用于前缀查询
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-bool-prefix-query.html
 */
class MatchBoolPrefixQuery extends Query
{

    /**
     * @var string
     */
    protected string $analyzer;

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'match_bool_prefix';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $value = $this->params
            ? $this->merge(['query' => $this->value])
            : $this->value;

        return [
            $this->field => $value
        ];
    }
}
