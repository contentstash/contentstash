<?php

namespace ContentStash\Core;

use ContentStash\Core\Facades\PluginRegistryFacade;
use ContentStash\Core\Services\PluginRegistry as PluginRegistryService;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use PluginRegistry;

class ContentStashServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'contentstash');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/contentstash'),
        ], 'contentstash-views');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    public function register()
    {
        $this->app->singleton(PluginRegistryService::class, function ($app) {
            return new PluginRegistryService;
        });

        $this->registerAliases();

        PluginRegistry::register([
            'name' => '@contentstash/core',
            'path' => __DIR__.'/../',
            'local_path' => __DIR__.'/../resources/ts/locales/',
        ]);
    }

    /**
     * Register aliases for the plugin
     */
    protected function registerAliases(): void
    {
        AliasLoader::getInstance()->alias('PluginRegistry', PluginRegistryFacade::class);
    }
}
