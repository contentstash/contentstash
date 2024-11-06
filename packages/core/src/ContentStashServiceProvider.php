<?php

namespace ContentStash\Core;

use Illuminate\Support\ServiceProvider;

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
        if (! defined('CONTENTSTASH_PLUGINS')) {
            $GLOBALS['CONTENTSTASH_PLUGINS'] = [];
        }

        $GLOBALS['CONTENTSTASH_PLUGINS'][] = [
            'name' => '@contentstash/core',
            'local_path' => __DIR__.'/../resources/ts/locales/',
        ];
    }
}
