<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Specialized;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * 提高更接近提供的原始日期或点的文档的相关性分数。
 * 还可以查询查找某个位置的最近邻居。
 * 还可以在"bool"搜索的"should"过滤器中使用查询，以将提升的相关性分数添加到"bool"查询的分数中。
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-distance-feature-query.html
 */
class DistanceFeatureQuery extends Query
{

    /**
     * 如果字段值为"date"或"date_nanos"字段，则原始值必须为日期。支持日期数学，例如 now-1h。
     * 如果字段值为"geo_point"字段，则原点值必须是地理点。
     *
     * @var mixed
     */
    protected mixed $origin;

    /**
     * 如果字段值为"date"或"date_nanos"字段，则必须是时间单位，例如"1h"或"10d"
     * 如果字段值为"geo_point"字段，则枢轴值必须是距离单位，例如"1km"或"12m"。
     * @var string
     */
    protected string $pivot;

    /**
     * 用于乘以匹配文档的相关性分数的浮点数。该值不能为负。
     *
     * @var float
     */
    protected float $boost = 1.0;

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'distance_feature';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->merge([
            'field' => $this->field,
            'origin' => $this->origin,
            'pivot' => $this->pivot,
            'boost' => $this->boost
        ]);
    }

    /**
     * @param string $pivot
     * @return $this
     */
    public function setPivot(string $pivot): static
    {
        $this->pivot = $pivot;

        return $this;
    }

    /**
     * @param mixed $origin
     * @return $this
     */
    public function setOrigin(mixed $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * @param float $boost
     * @return $this
     */
    public function setBoost(float $boost): static
    {
        $this->boost = $boost;

        return $this;
    }


}
