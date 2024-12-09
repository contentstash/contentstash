<?php

namespace ContentStash\Core\Facades;

use ContentStash\Core\Services\AttributeTypeRegistry;
use Illuminate\Support\Facades\Facade;

class AttributeTypeRegistryFacade extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return AttributeTypeRegistry::class;
    }
}
