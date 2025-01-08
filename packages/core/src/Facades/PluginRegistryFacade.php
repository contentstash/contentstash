<?php

namespace ContentStash\Core\Facades;

use ContentStash\Core\Services\PluginRegistry;
use Illuminate\Support\Facades\Facade;

class PluginRegistryFacade extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return PluginRegistry::class;
    }
}
