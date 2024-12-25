<?php

namespace ContentStash\Core\Attribute;

class BooleanAttributeType extends BaseAttributeType
{
    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'boolean';
    }

    /**
     * {@inheritDoc}
     */
    public function getPhpType(): string
    {
        return 'bool';
    }

    /**
     * {@inheritDoc}
     */
    public function getIcon(): string
    {
        return 'Binary';
    }

    /**
     * {@inheritDoc}
     */
    public function getClasses(): array
    {
        return [
            'badge' => 'bg-purple-100 text-purple-700',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getMigrationColumn(): string
    {
        return "\$table->boolean('{{name}}')";
    }

    /**
     * {@inheritDoc}
     */
    public function getValidationRules(): array
    {
        return ['required', 'boolean'];
    }

    /**
     * {@inheritDoc}
     */
    public function getFormSchema(): array
    {
        return array_merge(parent::getFormSchema(), [
            'defaultValue' => [
                'type' => 'boolean',
                'label' => 'attribute.type.defaultValue.label',
                'component' => 'switch',
            ],
        ]);
    }
}
