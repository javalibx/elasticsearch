<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch;

use Kabunx\Elasticsearch\Contracts\EndpointInterface;
use Kabunx\Elasticsearch\Contracts\QueryInterface;
use Kabunx\Elasticsearch\Endpoints\AggregationEndpoint;
use Kabunx\Elasticsearch\Endpoints\HighlightEndpoint;
use Kabunx\Elasticsearch\Endpoints\QueryEndpoint;
use Kabunx\Elasticsearch\Endpoints\SortEndpoint;
use Kabunx\Elasticsearch\Queries\Compound\BoolQuery;

class Builder
{
    /**
     * The index that should be returned.
     *
     * @var string
     */
    protected string $index = '';

    /**
     * The columns that should be returned.
     *
     * @var array
     */
    protected array $fields = [];

    /**
     * The number of records to skip.
     *
     * @var int
     */
    protected int $offset = 0;

    /**
     * The maximum number of records to return.
     *
     * @var int
     */
    protected int $limit = 15;

    /**
     * @var bool
     */
    protected bool $explain = false;

    /**
     * @var bool
     */
    protected bool $version = false;

    /**
     * @var EndpointInterface[]
     */
    protected array $endpoints = [];

    /**
     * @var string[]
     */
    protected array $operators = [
        '=', '>', '>=', '<', '<=', '!=', '<>'
    ];

    /**
     * @var array
     */
    protected array $hosts = [];

    /**
     * @var Engine
     */
    protected Engine $engine;

    /**
     * @var string[]
     */
    protected array $params = [
        'index' => 'index',
        'fields' => '_source',
        'offset' => 'from',
        'limit' => 'size',
        'storedFields' => 'stored_fields',
        'scriptFields' => 'script_fields',
        'explain' => 'explain',
        'version' => 'version',
        'indicesBoost' => 'indices_boost',
        'minScore' => 'min_score',
        'searchAfter' => 'search_after',
        'trackTotalHits' => 'track_total_hits',
    ];

    /**
     * @param array $fields
     * @return $this
     */
    public function select(array $fields): static
    {
        $this->fields = array_merge($this->fields, $fields);

        return $this;
    }

    /**
     * @param string $index
     * @return $this
     */
    public function from(string $index): static
    {
        $this->setIndex($index);

        return $this;
    }

    /**
     * @param string $field
     * @param string $operator
     * @param mixed $value
     * @param array $params
     * @return $this
     */
    public function where(string $field, string $operator, mixed $value, array $params = []): static
    {
        $this->getQueryEndpoint()->where($field, $operator, $value, $params);

        return $this;
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param array $params
     * @return $this
     */
    public function term(string $field, mixed $value, array $params = []): static
    {
        return $this->where($field, '=', $value, $params);
    }

    /**
     * @param string $field
     * @param array $value
     * @param array $params
     * @return $this
     */
    public function terms(string $field, array $value, array $params = []): static
    {
        $this->getQueryEndpoint()->terms($field, $value, $params);

        return $this;
    }

    /**
     * @param string $field
     * @return $this
     */
    public function exists(string $field): static
    {
        $this->getQueryEndpoint()->exists($field);

        return $this;
    }

    /**
     * @param array $ids
     * @return $this
     */
    public function ids(array $ids): static
    {
        $this->getQueryEndpoint()->ids($ids);

        return $this;
    }

    /**
     * @param string $field
     * @param string $value
     * @param array $params
     * @return $this
     */
    public function wildcard(string $field, string $value, array $params = []): static
    {
        return $this->where($field, 'wildcard', $value, $params);
    }

    /**
     * @param string $field
     * @param string $value
     * @param array $params
     * @return $this
     */
    public function like(string $field, string $value, array $params = []): static
    {
        return $this->wildcard($field, $value, $params);
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param array $params
     * @return $this
     */
    public function match(string $field, mixed $value, array $params = []): static
    {
        return $this->where($field, 'match', $value, $params);
    }

    public function between(string $field, int|float $min, int|float $max, array $params = []): static
    {
        $this->getQueryEndpoint()->between($field, $min, $max, $params);

        return $this;
    }

    /**
     * @param string $field
     * @param int|float $value
     * @param array $params
     * @return $this
     */
    public function gt(string $field, int|float $value, array $params = []): static
    {
        return $this->where($field, '>', $value, $params);
    }

    /**
     * @param string $field
     * @param int|float $value
     * @param array $params
     * @return $this
     */
    public function gte(string $field, int|float $value, array $params = []): static
    {
        return $this->where($field, '>=', $value, $params);
    }

    /**
     * @param string $field
     * @param int|float $value
     * @param array $params
     * @return $this
     */
    public function lt(string $field, int|float $value, array $params = []): static
    {
        return $this->where($field, '<', $value, $params);
    }

    /**
     * @param string $field
     * @param int|float $value
     * @param array $params
     * @return $this
     */
    public function lte(string $field, int|float $value, array $params = []): static
    {
        return $this->where($field, '<=', $value, $params);
    }

    /**
     * @param mixed $value
     * @param callable $callback
     * @return $this
     */
    public function when(mixed $value, callable $callback): static
    {
        if ($value) {
            call_user_func($callback, $this, $value);
        }

        return $this;
    }

    /**
     * @param QueryInterface $query
     * @param string $type
     * @return $this
     */
    public function addQuery(QueryInterface $query, string $type): static
    {
        $this->getQueryEndpoint()->addToBoolQuery($query, $type);

        return $this;
    }

    /**
     * @param callable $callback
     * @param string $type
     * @param bool $directly
     * @param float $boost
     * @return $this
     */
    public function bool(callable $callback, string $type, bool $directly = false, float $boost = 1.0): static
    {
        $builder = (new static());
        call_user_func($callback, $builder);
        $boolQuery = $builder->getQueryEndpoint()->getBoolQuery();
        $boolQuery->setBoost($boost);
        $this->getQueryEndpoint()->addBoolQuery(
            $boolQuery, $type, $directly
        );

        return $this;
    }

    /**
     * @param callable $callback
     * @param bool $directly
     * @param float $boost
     * @return $this
     */
    public function must(callable $callback, bool $directly = false, float $boost = 1.0): static
    {
        return $this->bool($callback, BoolQuery::MUST_QUERY, $directly, $boost);
    }

    /**
     * @param callable $callback
     * @param bool $directly
     * @param float $boost
     * @return $this
     */
    public function should(callable $callback, bool $directly = false, float $boost = 1.0): static
    {
        return $this->bool($callback, BoolQuery::SHOULD_QUERY, $directly, $boost);
    }

    /**
     * @param callable $callback
     * @param bool $directly
     * @return $this
     */
    public function filter(callable $callback, bool $directly = false): static
    {
        return $this->bool($callback, BoolQuery::FILTER_QUERY, $directly);
    }

    /**
     * @param callable $callback
     * @param bool $directly
     * @return $this
     */
    public function mustNot(callable $callback, bool $directly = true): static
    {
        return $this->bool($callback, BoolQuery::MUST_NOT_QUERY, $directly);
    }

    /**
     * @return $this
     */
    public function random(): static
    {
        $this->getSortEndpoint()->withRandomSort();

        return $this;
    }

    /**
     * @param string ...$fields
     * @return $this
     */
    public function orderByAsc(string ...$fields): static
    {
        foreach ($fields as $field) {
            $this->getSortEndpoint()->addFieldSort($field);
        }

        return $this;
    }

    /**
     * @param string ...$fields
     * @return $this
     */
    public function orderByDesc(string ...$fields): static
    {
        foreach ($fields as $field) {
            $this->getSortEndpoint()->addFieldSort($field, 'desc');
        }

        return $this;
    }

    public function orderByScoreDesc(): static
    {
        $this->getSortEndpoint()->addFieldSort('_score', 'desc');

        return $this;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function offset(int $offset): static
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param string $field
     * @param array $params
     * @return $this
     */
    public function highlight(string $field, array $params = []): static
    {
        $this->getHighlightEndpoint()->addField($field, $params);

        return $this;
    }

    /**
     * @param string $field
     * @return $this
     */
    public function sum(string $field): static
    {
        $this->getAggregationEndpoint()->sum($field);

        return $this;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->getEngine()->search($this->toSearchParams());
    }

    /**
     * @return array
     */
    public function first(): array
    {
        return $this->limit(1)->get();
    }

    /**
     * @param array $params
     * @return array
     */
    public function rawQuery(array $params): array
    {
        return $this->getEngine()->search($params);
    }

    /**
     * @return BoolQuery
     */
    public function getBoolQuery(): BoolQuery
    {
        return $this->getQueryEndpoint()->getBoolQuery();
    }

    /**
     * @param int $match
     * @return $this
     */
    public function setMinimumShouldMatch(int $match = 1): static
    {
        $this->getQueryEndpoint()->setMinimumShouldMatch($match);

        return $this;
    }

    /**
     * @return array
     */
    public function toQuery(): array
    {
        return $this->getQueryEndpoint()->toArray();
    }

    /**
     * @return array
     */
    public function toSearchParams(): array
    {
        $result = [];
        foreach ($this->params as $property => $param) {
            $result[$param] = $this->{$property} ?? null;
        }
        foreach ($this->endpoints as $endpoint) {
            if ($endpoint instanceof EndpointInterface) {
                $result['body'][$endpoint->getName()] = $endpoint->toArray();
            }
        }

        return array_filter($result);
    }

    /**
     * @param array $properties
     * @param bool $dynamic
     * @return array
     */
    public function createIndex(array $properties = [], bool $dynamic = true): array
    {
        return $this->getEngine()->createIndex($this->index, $properties, $dynamic);
    }

    /**
     * @return array
     */
    public function deleteIndex(): array
    {
        return $this->getEngine()->deleteIndex($this->index);
    }

    /**
     * @param array $data
     * @return array
     */
    public function update(array $data): array
    {
        return $this->getEngine()->update($this->index, $data);
    }

    /**
     * @param array $ids
     * @return array
     */
    public function delete(array $ids): array
    {
        return $this->getEngine()->delete($this->index, $ids);
    }

    /**
     * @param string $index
     * @return $this
     */
    public function setIndex(string $index): static
    {
        $this->index = $index;

        return $this;
    }

    /**
     * @param bool $explain
     * @return $this
     */
    public function setExplain(bool $explain): static
    {
        $this->explain = $explain;

        return $this;
    }

    /**
     * @param bool $version
     * @return $this
     */
    public function setVersion(bool $version): static
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @param array $hosts
     * @return $this
     */
    public function setHosts(array $hosts): static
    {
        $this->hosts = $hosts;

        return $this;
    }

    /**
     * @return QueryEndpoint
     */
    protected function getQueryEndpoint(): QueryEndpoint
    {
        if (! isset($this->endpoints['query'])) {
            $this->endpoints['query'] = new QueryEndpoint();
        }

        return $this->endpoints['query'];
    }

    /**
     * @return SortEndpoint
     */
    protected function getSortEndpoint(): SortEndpoint
    {
        if (! isset($this->endpoints['sort'])) {
            $this->endpoints['sort'] = new SortEndpoint();
        }

        return $this->endpoints['sort'];
    }

    /**
     * @return AggregationEndpoint
     */
    protected function getAggregationEndpoint(): AggregationEndpoint
    {
        if (! isset($this->endpoints['aggregation'])) {
            $this->endpoints['aggregation'] = new AggregationEndpoint();
        }

        return $this->endpoints['aggregation'];
    }

    /**
     * @return HighlightEndpoint
     */
    protected function getHighlightEndpoint(): HighlightEndpoint
    {
        if (! isset($this->endpoints['highlight'])) {
            $this->endpoints['highlight'] = new HighlightEndpoint();
        }

        return $this->endpoints['highlight'];
    }


    /**
     * @return Engine
     */
    protected function getEngine(): Engine
    {
        if (! isset($this->engine)) {
            $this->engine = new Engine($this->hosts);
        }

        return $this->engine;
    }
}
