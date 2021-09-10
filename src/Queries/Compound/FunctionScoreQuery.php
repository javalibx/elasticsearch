<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Compound;

use Kabunx\Elasticsearch\Contracts\CompoundQueryInterface;
use Kabunx\Elasticsearch\Contracts\QueryInterface;
use Kabunx\Elasticsearch\Queries\Query;

/**
 * 允许您修改查询检索到的文档的分数
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-function-score-query.html
 */
class FunctionScoreQuery extends Query implements CompoundQueryInterface
{
    /**
     * @var QueryInterface
     */
    protected QueryInterface $query;

    /**
     * @var float
     */
    protected float $boost = 0.0;

    protected int $maxBoost;

    protected string $boostMode;

    /**
     * @var string
     */
    protected string $scoreMode = 'multiply';

    protected int $minScore;

    /**
     * @var array
     */
    protected array $functions = [];

    /**
     * @var array
     */
    protected array $scoreModes = [
        'multiply', 'sum', 'avg', 'first', 'max', 'min'
    ];

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'function_score';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->merge([
            'query' => $this->query->toArray(),
        ], $this->functions);
    }

    /**
     * @param $source
     * @param array $params
     * @param array $options
     * @param QueryInterface|null $query
     * @return $this
     */
    public function addScriptScoreFunction(
        $source,
        array $params = [],
        array $options = [],
        QueryInterface $query = null
    ): static
    {
        $function = [
            'script_score' => [
                'script' => array_filter(
                    array_merge([
                        'lang' => 'painless',
                        'source' => $source,
                        'params' => $params
                    ], $options)
                )
            ],
        ];

        return $this->applyFunction($function, $query);
    }

    /**
     * @param string $type
     * @param string $column
     * @param array $function
     * @param array $options
     * @param QueryInterface|null $query
     * @param int|null $weight
     * @return $this
     */
    public function addDecayFunction(
        string         $type,
        string         $column,
        array          $function,
        array          $options = [],
        QueryInterface $query = null,
        int            $weight = null
    ): static
    {
        $function = array_filter([
            $type => array_merge(
                [$column => $function],
                $options
            ),
            'weight' => $weight,
        ]);

        return $this->applyFunction($function, $query);
    }

    /**
     * @param QueryInterface $query
     * @return $this
     */
    public function setQuery(QueryInterface $query): static
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @param array $function
     * @param QueryInterface|null $query
     * @return $this
     */
    protected function applyFunction(array $function, QueryInterface $query = null): static
    {
        if ($query) {
            $function['filter'] = $query->toArray();
        }
        $this->functions[] = $function;

        return $this;
    }

}
