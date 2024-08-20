<?php

namespace App\Http\Controllers;

use App\Http\Requests\AirportSearchRequest;
use App\Http\Resources\AirportSearchResource;
use App\Services\AirportSearchService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AirportSearchController extends Controller
{
    public function __construct(AirportSearchService $elasticsearchService)
    {
        $this->elasticsearchService = $elasticsearchService;
    }

    public function search(AirportSearchRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $query = $validated['query'];

        try {
            $results = $this->elasticsearchService->searchByCityName($query);

            if (empty($results)) {
                return response()->json([
                    'data' =>[]
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'data' => AirportSearchResource::collection($results)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
