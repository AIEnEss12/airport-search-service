<?php

namespace App\Repositories\Elastic;

interface ElasticsearchRepositoryInterface
{
    public function searchByCityName(string $query): array;
}
