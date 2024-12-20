<?php

namespace ContentStash\Core\Attribute;

class JsonAttributeType extends BaseAttributeType
{
    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'json';
    }

    /**
     * {@inheritDoc}
     */
    public function getPhpType(): string
    {
        return 'array';
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): ?string
    {
        return 'json';
    }

    /**
     * {@inheritDoc}
     */
    public function getIcon(): string
    {
        return 'Braces';
    }

    /**
     * {@inheritDoc}
     */
    public function getClasses(): array
    {
        return [
            'badge' => 'bg-green-100 text-green-700',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getMigrationColumn(): string
    {
        return "\$table->json('{{name}}')";
    }

    /**
     * {@inheritDoc}
     */
    public function getValidationRules(): array
    {
        return ['required', 'json'];
    }

    /**
     * {@inheritDoc}
     */
    // public function getFormComponent(): string
    // {
    //     return '<textarea :value="JSON.stringify(value)" @input="updateValue(JSON.parse($event.target.value))"></textarea>';
    // }
}
