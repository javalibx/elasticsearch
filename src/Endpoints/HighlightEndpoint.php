<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch\Endpoints;

use Kabunx\Elasticsearch\Contracts\EndpointInterface;
use Kabunx\Elasticsearch\HasParams;
use stdClass;

/**
 *
 */
class HighlightEndpoint implements EndpointInterface
{
    use HasParams;

    /**
     * @var array
     */
    protected array $fields = [];

    /**
     * @var array
     */
    protected array $tags = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'highlight';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $output = $this->tags ?: [];
        $output = $this->merge($output);
        foreach ($this->fields as $field => $params) {
            $output['fields'][$field] = count($params) ? $params : new stdClass();
        }

        return $output;
    }

    /**
     * @param string $field
     * @param array $params
     * @return $this
     */
    public function addField(string $field, array $params = []): static
    {
        $this->fields[$field] = $params;

        return $this;
    }
}
