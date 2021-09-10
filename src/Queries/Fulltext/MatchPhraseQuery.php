<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Fulltext;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 查询分析文本并根据分析的文本创建短语查询
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query-phrase.html
 */
class MatchPhraseQuery extends Query
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'match_phrase';
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
