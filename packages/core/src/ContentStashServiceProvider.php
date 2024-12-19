<?php

namespace ContentStash\Core;

use AttributeTypeRegistry;
use ContentStash\Core\Enums\AttributeTypeFormat;
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
                'icon' => 'Sigma',
                'classes' => [
                    'badge' => 'bg-blue-100 text-blue-700',
                ],
            ],
            [
                'name' => 'bigint',
                'phpType' => 'int',
                'type' => 'bigint',
                'icon' => 'Sigma',
                'classes' => [
                    'badge' => 'bg-blue-100 text-blue-700',
                ],
            ],
            [
                'name' => 'string',
                'phpType' => 'string',
                'icon' => 'Type',
                'classes' => [
                    'badge' => 'bg-red-100 text-red-700',
                ],
            ],
            [
                'name' => 'text',
                'phpType' => 'string',
                'type' => 'text',
                'icon' => 'Type',
                'classes' => [
                    'badge' => 'bg-red-100 text-red-700',
                ],
            ],
            [
                'name' => 'timestamp',
                'phpType' => '\Carbon\CarbonInterface',
                'icon' => 'CalendarClock',
                'classes' => [
                    'badge' => 'bg-yellow-100 text-yellow-700',
                ],
                'format' => AttributeTypeFormat::DateTime,
            ],
            [
                'name' => 'boolean',
                'phpType' => 'bool',
                'icon' => 'Binary',
                'classes' => [
                    'badge' => 'bg-purple-100 text-purple-700',
                ],
            ],
            [
                'name' => 'json',
                'phpType' => 'array',
                'type' => 'json',
                'icon' => 'Braces',
                'classes' => [
                    'badge' => 'bg-green-100 text-green-700',
                ],
            ],
        ]);
    }
}
