<?php

namespace App\Repositories\Elastic;

use Elastic\Elasticsearch\Client;

class ElasticsearchRepository implements ElasticsearchRepositoryInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function searchByCityName(string $query): array
    {
        $params = [
            'index' => env('ELASTICSEARCH_AIRPORT_INDEX', 'cities'),
            'body'  => [
                'query' => [
                    'bool' => [
                        'should' => [
                            [
                                'match' => [
                                    "cityName.en" => $query,
                                ]
                            ],
                            [
                                'match' => [
                                    "cityName.ru" => $query,
                                ]
                            ]
                        ]
                    ],
                ]
            ]
        ];

        try {
            $response = $this->client->search($params);
            return $response['hits']['hits'];
        } catch (\Exception $e) {
            throw new \Exception('Search failed: ' . $e->getMessage());
        }
    }
}
