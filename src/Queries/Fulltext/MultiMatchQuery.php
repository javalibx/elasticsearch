<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Queries\Fulltext;

use Kabunx\Elasticsearch\Queries\Query;

/**
 * Class MultiMatchQuery
 * @package Kabunx\Elasticsearch\Queries\Fulltext
 */
class MultiMatchQuery extends Query
{
    /**
     *
     * @var array
     */
    protected array $fields = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'multi_match';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $query = [
            'query' => (string)$this->value,
        ];
        if ($this->fields) {
            $query['fields'] = $this->fields;
        }

        return $this->merge($query);
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function setFields(array $fields): static
    {
        $this->fields = $fields;

        return $this;
    }


}
