<?php

namespace ContentStash\Core;

use ContentStash\Core\Plugins\ContentStashPlugin;
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

        $GLOBALS['CONTENTSTASH_PLUGINS'][] = new ContentStashPlugin([
            'name' => '@contentstash/core',
            'path' => __DIR__.'/../',
            'local_path' => __DIR__.'/../resources/ts/locales/',
        ]);
    }
}
