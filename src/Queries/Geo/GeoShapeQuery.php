<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Geo;

/**
 * 查询使用与映射相同的网格正方形表示来查找形状与查询形状相交的文档。
 * 它还将使用为字段映射定义的相同前缀树配置。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-shape-query.html
 */
class GeoShapeQuery extends GeoQuery
{

    /**
     * @var array
     */
    protected array $coordinates;

    /**
     * @var string
     */
    protected string $relation;

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'geo_shape';
    }

    /**
     * @param array $coordinates
     * @return $this
     */
    public function setCoordinates(array $coordinates): static
    {
        $this->coordinates = $coordinates;
        $this->location['shape'] = [
            'type' => 'envelope',
            'coordinates' => $coordinates
        ];

        return $this;
    }

    /**
     * @param string $relation
     * @return $this
     */
    public function setRelation(string $relation): static
    {
        $this->relation = $relation;
        $this->location['relation'] = $relation;

        return $this;
    }


}
