<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Fulltext;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 以与提供的相同的顺序返回包含提供的文本的单词的文档。
 * 提供的文本的最后一个术语被视为前缀，匹配以该术语开头的任何单词。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query-phrase-prefix.html
 */
class MatchPhrasePrefixQuery extends Query
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'match_phrase_prefix';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            $this->field => $this->merge([
                'query' => $this->value
            ])
        ];
    }

}
