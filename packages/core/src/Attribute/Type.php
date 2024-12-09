<?php

namespace ContentStash\Core\Attribute;

class Type
{
    /**
     * The name of the attribute type.
     */
    protected string $name;

    /**
     * List of additional attributes
     */
    protected array $additionalAttributes = [];

    /**
     * List of required attributes
     */
    protected static array $requiredAttributes = [
        'name',
    ];

    /**
     * Create a new instance of the attribute type.
     */
    public function __construct(array $attributes)
    {
        // check if $required attributes are set
        if ($missing = array_diff(self::$requiredAttributes, array_keys($attributes))) {
            dd([
                'message' => 'Missing required attributes for contentstash attribute type'.($attributes['name'] ?? 'unknown'),
                'missing' => $missing,
            ]);
        }

        $this->name = $attributes['name'];
        $this->additionalAttributes = array_diff_key($attributes, array_flip(array_merge(self::$requiredAttributes, ['local_path'])));
    }

    /**
     * Get the name of the attribute type.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the additional attributes of the attribute type.
     */
    public function getAdditionalAttributes(): array
    {
        return $this->additionalAttributes;
    }
}
