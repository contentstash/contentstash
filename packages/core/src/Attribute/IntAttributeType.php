<?php

namespace ContentStash\Core\Attribute;

class IntAttributeType extends BaseAttributeType
{
    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'int';
    }

    /**
     * {@inheritDoc}
     */
    public function getPhpType(): string
    {
        return 'int';
    }

    /**
     * {@inheritDoc}
     */
    public function getIcon(): string
    {
        return 'Sigma';
    }

    /**
     * {@inheritDoc}
     */
    public function getClasses(): array
    {
        return [
            'badge' => 'bg-blue-100 text-blue-700',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getMigrationColumn(): string
    {
        return "\$table->integer('{{name}}')";
    }

    /**
     * {@inheritDoc}
     */
    public function getValidationRules(): array
    {
        return ['required', 'integer'];
    }

    /**
     * {@inheritDoc}
     */
    // public function getFormComponent(): string
    // {
    //     return '<input type="number" :value="value" @input="updateValue($event.target.value)" />';
    // }
}
