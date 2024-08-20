<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AirportSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['_id'],
            'cityName' => [
                'ru' => $this['_source']['cityName']['ru'] ?? null,
                'en' => $this['_source']['cityName']['en'] ?? null,
            ],
            'area' => $this['_source']['area'] ?? null,
            'country' => $this['_source']['country'] ?? null,
            'timezone' => $this['_source']['timezone'] ?? null,
        ];
    }
}
