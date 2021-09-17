<?php
declare(strict_types=1);

namespace Kabunx\Elasticsearch;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class Engine
{

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var Builder
     */
    protected Builder $builder;


    /**
     * Engine constructor.
     * @param array $hosts
     */
    public function __construct(array $hosts)
    {
        $this->client = ClientBuilder::create()
            ->setHosts($hosts)
            ->build();
    }

    /**
     * @param string $index
     * @param array $properties
     * @param bool $dynamic
     * @return array
     */
    public function createIndex(string $index, array $properties = [], bool $dynamic = true): array
    {
        return $this->client->indices()->create([
            'index' => $index,
            'body' => [
                'mappings' => [
                    'dynamic' => $dynamic,
                    'properties' => $properties
                ]
            ]
        ]);
    }

    /**
     * @param string $index
     * @return array
     */
    public function deleteIndex(string $index): array
    {
        if ($this->indexExists($index)) {
            return $this->client->indices()->delete([
                'index' => $index
            ]);
        }
        return [];
    }

    public function indexExists(string $index): bool
    {
        return $this->client->indices()->exists([
            'index' => $index
        ]);
    }


    /**
     * @param array $params
     * @return array
     */
    public function search(array $params): array
    {
        return $this->client->search($params);
    }

    /**
     * @param string $index
     * @param array $data
     * @return array
     */
    public function update(string $index, array $data): array
    {
        $body = [];
        foreach ($data as $item) {
            if (isset($item['id']) && isset($item['doc'])) {
                $body[] = [
                    'update' => [
                        '_id' => $item['id'],
                        '_index' => $index,
                    ]
                ];
                $body[] = [
                    'doc' => $item['doc'],
                    'doc_as_upsert' => true
                ];
            }
        }

        return $this->client->bulk(['body' => $body]);
    }

    /**
     * @param string $index
     * @param array $ids
     * @return array
     */
    public function delete(string $index, array $ids): array
    {
        $body = [];
        foreach ($ids as $id) {
            $body = [
                'delete' => [
                    '_id' => $id,
                    '_index' => $index
                ]
            ];
        }

        return $this->client->bulk(['body' => $body]);
    }
}
