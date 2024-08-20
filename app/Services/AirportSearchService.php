<?php

namespace App\Services;

use App\Repositories\Elastic\ElasticsearchRepositoryInterface;

class AirportSearchService implements AirportSearchServiceInterface
{
    private $repository;

    public function __construct(ElasticsearchRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function searchByCityName(string $query): array
    {
        return $this->repository->searchByCityName($query);
    }
}
