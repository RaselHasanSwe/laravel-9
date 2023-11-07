<?php

namespace App\Providers;


use App\Services\ElasticsearchService;
use App\Services\RedisStoreService;
use App\Utilities\Contracts\ElasticsearchHelperInterface;
use App\Utilities\Contracts\RedisHelperInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(RedisHelperInterface::class, function(Application $app){
            return new RedisStoreService();
        });

        $this->app->bind(ElasticsearchHelperInterface::class, function(Application $app){
            return new ElasticsearchService();
        });
    }
}
