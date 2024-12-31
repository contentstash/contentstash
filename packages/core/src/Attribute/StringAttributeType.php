<?php

namespace ContentStash\Core\Attribute;

class StringAttributeType extends BaseAttributeType
{
    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'string';
    }

    /**
     * {@inheritDoc}
     */
    public function getPhpType(): string
    {
        return 'string';
    }

    /**
     * {@inheritDoc}
     */
    public function getIcon(): string
    {
        return 'Type';
    }

    /**
     * {@inheritDoc}
     */
    public function getClasses(): array
    {
        return [
            'badge' => 'bg-red-100 text-red-700',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getMigrationColumn(): array
    {
        return array_merge(parent::getMigrationColumn(), [
            'name' => [
                'up' => 'string(\'{{name}}\')',
                'diff' => 'renameColumn(\'{{name}}\')',
            ],
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getValidationRules(): array
    {
        return ['required', 'string'];
    }

    /**
     * {@inheritDoc}
     */
    public function getFormSchema(): array
    {
        return array_merge(parent::getFormSchema(), [
            'defaultValue' => [
                'type' => 'string',
                'label' => 'attribute.type.defaultValue.label',
            ],
        ]);
    }
}
