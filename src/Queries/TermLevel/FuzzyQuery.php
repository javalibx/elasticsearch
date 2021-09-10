<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\TermLevel;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 返回包含与搜索词相似的词的文档。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-fuzzy-query.html
 */
class FuzzyQuery extends Query
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'fuzzy';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            $this->field => $this->merge([
                'value' => $this->value
            ]),
        ];
    }

}
