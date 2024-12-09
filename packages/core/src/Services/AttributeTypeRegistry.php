<?php

namespace ContentStash\Core\Services;

use ContentStash\Core\Attribute\Type;
use Illuminate\Support\Collection;

class AttributeTypeRegistry
{
    /**
     * List of registered attribute types.
     */
    protected Collection $attributeTypes;

    public function __construct()
    {
        $this->attributeTypes = collect();
    }

    /**
     * Register a new attribute type.
     */
    public function register(array $attributes): Type
    {
        $attributeType = new Type($attributes);

        if ($this->get($attributeType->getName())) {
            throw new \Exception('Attribute type with name '.$attributeType->getName().' already exists.');
        }

        $this->attributeTypes[$attributeType->getName()] = $attributeType;

        return $attributeType;
    }

    /**
     * Get all registered attribute types.
     */
    public function all(): Collection
    {
        return $this->attributeTypes;
    }

    /**
     * Get a attribute type by name.
     */
    public function get(string $name): ?Type
    {
        return $this->attributeTypes->get($name);
    }
}
