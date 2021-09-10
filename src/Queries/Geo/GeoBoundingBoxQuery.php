<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Geo;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-bounding-box-query.html
 */
class GeoBoundingBoxQuery extends GeoQuery
{

    /**
     * @var float
     */
    protected float $top;

    /**
     * @var float
     */
    protected float $left;

    /**
     * @var float
     */
    protected float $bottom;

    /**
     * @var float
     */
    protected float $right;

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'geo_bounding_box';
    }

    /**
     * @param float $top
     * @param float $left
     * @param float $bottom
     * @param float $right
     * @return $this
     */
    public function setTopLeftBottomRight(
        float $top,
        float $left,
        float $bottom,
        float $right
    ): static
    {
        $this->top = $top;
        $this->left = $left;
        $this->bottom = $bottom;
        $this->right = $right;
        $this->location = [
            'top' => $top,
            'left' => $left,
            'bottom' => $bottom,
            'right' => $right
        ];

        return $this;
    }

}
