<?php

namespace ContentStash\Core\Attribute;

use ContentStash\Core\Enums\AttributeTypeFormat;

abstract class BaseAttributeType
{
    /**
     * Get the name of the attribute type.
     */
    abstract public function getName(): string;

    /**
     * Get the PHP type of the attribute
     */
    abstract public function getPhpType(): string;

    /**
     * Get the type of the attribute
     */
    public function getType(): ?string
    {
        return null;
    }

    /**
     * Get the icon representing the attribute type.
     */
    public function getIcon(): string
    {
        return 'CircleHelp';
    }

    /**
     * Get the styling classes for the attribute type.
     */
    public function getClasses(): array
    {
        return [
            'badge' => 'bg-gray-100 text-gray-700',
        ];
    }

    /**
     * Get the format of the attribute type.
     */
    public function getFormat(): AttributeTypeFormat
    {
        return AttributeTypeFormat::Raw;
    }

    /**
     * Get the database migration column definition for this attribute type.
     */
    abstract public function getMigrationColumn(): string;

    /**
     * Get the cast type for Laravel models.
     */
    public function getCast(): ?string
    {
        return null;
    }

    /**
     * Get the validation rules for this attribute type.
     */
    public function getValidationRules(): array
    {
        return [];
    }

    /**
     * Get the frontend form schema for this attribute type.
     */
    public function getFormSchema(): array
    {
        return [
            'name' => [
                'type' => 'string',
                'label' => 'attribute.type.name.label',
                'description' => 'attribute.type.name.description',
                'placeholder' => 'attribute.type.name.placeholder',
                'required' => true,
            ],
            'required' => [
                'type' => 'boolean',
                'label' => 'attribute.type.required.label',
                'description' => 'attribute.type.required.description',
                'default' => false,
                'component' => 'switch',
            ],
        ];
    }

    /**
     * Return the structure of the attribute type as an array.
     */
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'phpType' => $this->getPhpType(),
            'type' => $this->getType(),
            'icon' => $this->getIcon(),
            'classes' => $this->getClasses(),
            'format' => $this->getFormat()->value,
            'migration' => $this->getMigrationColumn(),
            'cast' => $this->getCast(),
            'validation' => $this->getValidationRules(),
            'formSchema' => $this->getFormSchema(),
        ];
    }
}
