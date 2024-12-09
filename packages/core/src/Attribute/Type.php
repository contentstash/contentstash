<?php

namespace ContentStash\Core\Attribute;

class Type
{
    /**
     * The name of the attribute type.
     */
    protected string $name;

    /**
     * The phpType of the attribute type.
     */
    protected string $phpType;

    /**
     * The type of the attribute type.
     */
    protected ?string $type = null;

    /**
     * List of additional attributes
     */
    protected array $additionalAttributes = [];

    /**
     * List of required attributes
     */
    protected static array $requiredAttributes = [
        'name',
        'phpType',
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
        $this->phpType = $attributes['phpType'];
        if (isset($attributes['type'])) {
            $this->type = $attributes['type'];
        }
        $this->additionalAttributes = array_diff_key($attributes, array_flip(array_merge(self::$requiredAttributes, ['type'])));
    }

    /**
     * Get attribute type as array.
     */
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'phpType' => $this->getPhpType(),
            'type' => $this->getType(),
            'additional_attributes' => $this->getAdditionalAttributes(),
        ];
    }

    /**
     * Get the name of the attribute type.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the phpType of the attribute type.
     */
    public function getPhpType(): string
    {
        return $this->phpType;
    }

    /**
     * Get the type of the attribute type.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Get the additional attributes of the attribute type.
     */
    public function getAdditionalAttributes(): array
    {
        return $this->additionalAttributes;
    }
}
