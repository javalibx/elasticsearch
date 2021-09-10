<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Endpoints;

use Kabunx\Elasticsearch\Contracts\EndpointInterface;
use Kabunx\Elasticsearch\Contracts\QueryInterface;
use Kabunx\Elasticsearch\Queries\Compound\BoolQuery;
use Kabunx\Elasticsearch\Queries\ToQuery;

class QueryEndpoint implements EndpointInterface
{
    use ToQuery;

    /**
     * @var BoolQuery
     */
    protected BoolQuery $boolQuery;

    /**
     * @var array
     */
    protected array $params = [];

    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->params = $params;
        $this->boolQuery = new BoolQuery();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'query';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->boolQuery->body();
    }

    /**
     * @param QueryInterface $query
     * @param string $type
     * @return $this
     */
    public function addQuery(QueryInterface $query, string $type = BoolQuery::MUST_QUERY): static
    {
        return $this->addToBoolQuery($query, $type);
    }

    /**
     * @param QueryInterface $query
     * @param string $type
     * @return $this
     */
    public function addToBoolQuery(QueryInterface $query, string $type): static
    {
        $this->boolQuery->addQuery($query, $type);

        return $this;
    }

    /**
     * @param BoolQuery $query
     * @param string $type
     * @param bool $directly
     * @return $this
     */
    public function addBoolQuery(BoolQuery $query, string $type, bool $directly = false): static
    {
        if ($query->isEmpty()) {
            return $this;
        }
        if ($directly) {
            foreach ($query->getTypeQueries() as $queries) {
                foreach ($queries as $query) {
                    $this->addToBoolQuery($query, $type);
                }
            }
        } else {
            if ($crossedQuery = $query->getCrossedQuery($type)) {
                $this->addToBoolQuery($crossedQuery, $type);
            } else {
                $this->addToBoolQuery($query, $type);
            }
        }

        return $this;
    }

    /**
     * @return BoolQuery
     */
    public function getBoolQuery(): BoolQuery
    {
        return $this->boolQuery;
    }
}
