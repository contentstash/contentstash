<?php

namespace ContentStash\Core\Services;

use ContentStash\Core\Attribute\BaseAttributeType;
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
    public function register(string $attributeTypeClass): BaseAttributeType
    {
        if (! is_subclass_of($attributeTypeClass, BaseAttributeType::class)) {
            throw new \InvalidArgumentException('Each item must be a subclass of BaseAttributeType.');
        }

        $attributeType = new $attributeTypeClass;
        if ($this->get($attributeType->getPhpType(), $attributeType->getType(), true)) {
            throw new \Exception('Attribute type with phpType "'.$attributeType->getPhpType().'" and type "'.$attributeType->getType().'" already exists.');
        }

        $this->attributeTypes->push($attributeType);

        return $attributeType;
    }

    /**
     * Register multiple attribute types.
     */
    public function registerMany(array $attributeTypes): Collection
    {
        $registeredAttributeTypes = collect();
        foreach ($attributeTypes as $attributeTypeClass) {
            if (! is_subclass_of($attributeTypeClass, BaseAttributeType::class)) {
                throw new \InvalidArgumentException('Each item must be a subclass of BaseAttributeType.');
            }

            $registeredAttributeTypes->push($this->register($attributeTypeClass));
        }

        return $registeredAttributeTypes;
    }

    /**
     * Get all registered attribute types.
     */
    public function all(): Collection
    {
        return $this->attributeTypes;
    }

    /**
     * Get all registered attribute types as array.
     */
    public function allAsArray(): array
    {
        return $this->attributeTypes->map(fn (BaseAttributeType $type) => $type->toArray())->toArray();
    }

    /**
     * Get an attribute type by phpType and type.
     * Prioritize matching both phpType and type, then fallback to phpType with type null.
     *
     * @param  bool  $exactMatch  If true, both phpType and type must match exactly.
     */
    public function get(string $phpType, ?string $type = null, bool $exactMatch = false): ?BaseAttributeType
    {
        if ($exactMatch) {
            return $this->attributeTypes->first(
                fn (BaseAttributeType $attributeType) => $attributeType->getPhpType() === $phpType && $attributeType->getType() === $type
            );
        }

        $attributeType = $this->attributeTypes->first(
            fn (BaseAttributeType $attributeType) => $attributeType->getPhpType() === $phpType && $attributeType->getType() === $type
        );

        if ($attributeType === null && $type !== null) {
            $attributeType = $this->attributeTypes->first(
                fn (BaseAttributeType $attributeType) => $attributeType->getPhpType() === $phpType && $attributeType->getType() === null
            );
        }

        return $attributeType;
    }
}
