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
    // public function getFormComponent(): string
    // {
    //     return '<input type="checkbox" :checked="value" @change="updateValue($event.target.checked)" />';
    // }
}
