<?php

namespace ContentStash\Core\Attribute;

use ContentStash\Core\Helpers\ArrayHelper;

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
    public function getMigrationDefinition(): array
    {
        return ArrayHelper::mergeRecursiveDistinct(parent::getMigrationDefinition(), [
            'name' => 'string(\'{{name}}\')',
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
            // 'defaultValue' => [
            //     'type' => 'string',
            //     'label' => 'attribute.type.defaultValue.label',
            // ],
        ]);
    }
}
