<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Geo;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/geo-queries.html
 */
abstract class GeoQuery extends Query
{

    /**
     *
     * 经纬度 longitude and latitude
     *
     * @var array
     */
    protected array $location = [];

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            $this->field => $this->location
        ];
    }

    /**
     * @param array $location
     * @return $this
     */
    public function setLocation(array $location): static
    {
        $this->location = $location;

        return $this;
    }


}
