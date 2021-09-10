<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Geo;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-distance-query.html
 */
class GeoDistanceQuery extends GeoQuery
{

    /**
     * 纬度
     * @var float
     */
    protected float $lat;

    /**
     * 经度
     * @var float
     */
    protected float $lon;

    /**
     * 距离描述（15km）
     * @var string
     */
    protected string $distance;

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'geo_distance';
    }

    /**
     * @param string $distance
     * @return $this
     */
    public function setDistance(string $distance): static
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * @param float $lon
     * @param float $lat
     * @return $this
     */
    public function setLonLat(float $lon, float $lat): static
    {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->location = [$lon, $lat];

        return $this;
    }
}
