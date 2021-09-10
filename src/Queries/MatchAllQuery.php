<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries;

use stdClass;

/**
 * Class MatchAllQuery
 * @package Kabunx\Elasticsearch\Queries
 */
class MatchAllQuery extends Query
{
    /**
     * @var float
     */
    protected float $boost;

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'match_all';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->getParams();
    }

    /**
     * @return array
     */
    public function body(): array
    {
        $output = $this->toArray();

        return [
            $this->getName() => $output ?: new stdClass()
        ];
    }

    /**
     * @param float $boost
     * @return $this
     */
    public function setBoost(float $boost): static
    {
        $this->boost = $boost;
        $this->addParam('boost', $boost);

        return $this;
    }


}
