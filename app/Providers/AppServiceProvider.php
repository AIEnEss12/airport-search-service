<?php

namespace App\Providers;

use App\Repositories\Elastic\ElasticsearchRepository;
use App\Repositories\Elastic\ElasticsearchRepositoryInterface;
use App\Services\AirportSearchService;
use App\Services\AirportSearchServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ElasticsearchRepositoryInterface::class, ElasticsearchRepository::class);

        // Bind service interface to implementation
        $this->app->bind(AirportSearchServiceInterface::class, AirportSearchService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
