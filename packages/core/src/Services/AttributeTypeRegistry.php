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

        if ($result = $this->get($attributeType->getPhpType(), $attributeType->getType(), true)) {
            throw new \Exception('Attribute type with phpType "'.$attributeType->getPhpType().'" and type "'.$attributeType->getType().'" already exists with name "'.$result->getName().'"');
        }

        $this->attributeTypes->push($attributeType);

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
     * Get all registered attribute types as array.
     */
    public function allAsArray(): array
    {
        return $this->attributeTypes->map(function (Type $attributeType) {
            return $attributeType->toArray();
        })->toArray();
    }

    /**
     * Get an attribute type by phpType and type.
     * Prioritize matching both phpType and type, then fallback to phpType with type null.
     *
     * @param  bool  $exactMatch  If true, both phpType and type must match exactly.
     */
    public function get(string $phpType, ?string $type = null, bool $exactMatch = false): ?Type
    {
        if ($exactMatch) {
            $attributeType = $this->attributeTypes->first(function (Type $attributeType) use ($phpType, $type) {
                return $attributeType->getPhpType() === $phpType && $attributeType->getType() === $type;
            });
        } else {
            $attributeType = $this->attributeTypes->first(function (Type $attributeType) use ($phpType, $type) {
                return $attributeType->getPhpType() === $phpType && $attributeType->getType() === $type;
            });

            if ($attributeType === null && $type !== null) {
                $attributeType = $this->attributeTypes->first(function (Type $attributeType) use ($phpType) {
                    return $attributeType->getPhpType() === $phpType && $attributeType->getType() === null;
                });
            }
        }

        return $attributeType;
    }
}
