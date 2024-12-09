<?php

namespace ContentStash\Core;

use AttributeTypeRegistry;
use ContentStash\Core\Facades\AttributeTypeRegistryFacade;
use ContentStash\Core\Facades\PluginRegistryFacade;
use ContentStash\Core\Services\AttributeTypeRegistry as AttributeTypeRegistryService;
use ContentStash\Core\Services\PluginRegistry as PluginRegistryService;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use PluginRegistry;

class ContentStashServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'contentstash');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/contentstash'),
        ], 'contentstash-views');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->registerSingleton();

        PluginRegistry::register([
            'name' => '@contentstash/core',
            'path' => __DIR__.'/../',
            'local_path' => __DIR__.'/../resources/ts/locales/',
        ]);

        $this->registerAttributeTypes();
    }

    /**
     * Register singletons
     */
    protected function registerSingleton(): void
    {
        $this->app->singleton(PluginRegistryService::class, function ($app) {
            return new PluginRegistryService;
        });
        $this->app->singleton(AttributeTypeRegistryService::class, function ($app) {
            return new AttributeTypeRegistryService;
        });

        AliasLoader::getInstance()->alias('PluginRegistry', PluginRegistryFacade::class);
        AliasLoader::getInstance()->alias('AttributeTypeRegistry', AttributeTypeRegistryFacade::class);
    }

    /**
     * Register attribute types
     */
    protected function registerAttributeTypes(): void
    {
        AttributeTypeRegistry::registerMany([
            [
                'name' => 'int',
                'phpType' => 'int',
            ],
            [
                'name' => 'bigint',
                'phpType' => 'int',
                'type' => 'bigint',
            ],
            [
                'name' => 'string',
                'phpType' => 'string',
            ],
            [
                'name' => 'timestamp',
                'phpType' => '\Carbon\CarbonInterface',
            ],
            [
                'name' => 'boolean',
                'phpType' => 'bool',
            ],
            [
                'name' => 'json',
                'phpType' => 'array',
                'type' => 'json',
            ],
        ]);
    }
}
