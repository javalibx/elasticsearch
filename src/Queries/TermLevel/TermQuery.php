<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\TermLevel;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 返回在提供的字段中包含确切术语的文档。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-term-query.html
 */
class TermQuery extends Query
{

    /**
     * @var float
     */
    protected float $boost = 1.0;

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'term';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            $this->field => $this->merge([
                'value' => $this->value
            ])
        ];
    }
}
