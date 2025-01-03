<?php

namespace ContentStash\Core;

use AttributeTypeRegistry;
use ContentStash\Core\Attribute\BigIntAttributeType;
use ContentStash\Core\Attribute\BooleanAttributeType;
use ContentStash\Core\Attribute\IntAttributeType;
use ContentStash\Core\Attribute\JsonAttributeType;
use ContentStash\Core\Attribute\StringAttributeType;
use ContentStash\Core\Attribute\TextAttributeType;
use ContentStash\Core\Attribute\TimestampAttributeType;
use ContentStash\Core\Facades\AttributeTypeRegistryFacade;
use ContentStash\Core\Facades\PluginRegistryFacade;
use ContentStash\Core\Services\AttributeTypeRegistry as AttributeTypeRegistryService;
use ContentStash\Core\Services\PluginRegistry as PluginRegistryService;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use PluginRegistry;

class ContentStashServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function boot()
    {
        $this->offerPublishing();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'contentstash');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
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
            BigIntAttributeType::class,
            BooleanAttributeType::class,
            IntAttributeType::class,
            JsonAttributeType::class,
            StringAttributeType::class,
            TextAttributeType::class,
            TimestampAttributeType::class,
        ]);
    }

    /**
     * Setup the resource publishing groups for ContentStash.
     */
    protected function offerPublishing(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/contentstash'),
        ], 'contentstash-views');

        $this->publishes([
            __DIR__.'/../database/migrations/add_is_system_to_roles_table.php' => $this->getMigrationFileName('add_is_system_to_roles_table.php'),
            __DIR__.'/../database/migrations/create_permissions_and_roles.php' => $this->getMigrationFileName('create_permissions_and_roles.php'),
        ], 'contentstash-migrations');
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     */
    protected function getMigrationFileName(string $migrationFileName): string
    {
        $timestamp = date('Y_m_d_His');

        $filesystem = $this->app->make(FileSystem::class);

        return Collection::make([$this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR])
            ->flatMap(fn ($path) => $filesystem->glob($path.'*_'.$migrationFileName))
            ->push($this->app->databasePath()."/migrations/{$timestamp}_{$migrationFileName}")
            ->first();
    }
}
