<?php

namespace ContentStash\Core\Facades;

use Illuminate\Support\Facades\Facade;

class PluginRegistryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \ContentStash\Core\Services\PluginRegistry::class;
    }
}
