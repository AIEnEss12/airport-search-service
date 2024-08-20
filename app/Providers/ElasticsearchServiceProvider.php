<?php

namespace App\Providers;

use Elastic\Elasticsearch\Client;
use Illuminate\Support\ServiceProvider;

class ElasticsearchServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Client::class, function ($app) {
            return \Elastic\Elasticsearch\ClientBuilder::create()->setHosts([config('elasticsearch.host')])->build();
        });
    }
}
