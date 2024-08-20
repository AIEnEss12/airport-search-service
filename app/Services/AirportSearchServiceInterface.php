<?php

namespace App\Services;

interface AirportSearchServiceInterface
{
    public function searchByCityName(string $query): array;
}
