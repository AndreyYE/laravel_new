<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Contracts\Foundation\Application;

class SearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function (Application $app) {
            $config = $app->make('config')->get('elasticsearch');
            $hosts = $config['hosts'] ? [$config['hosts']] : ["localhost:9201"];
            return ClientBuilder::create()
                ->setHosts($hosts)
                ->setRetries($config['retries'])
                ->build();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
