<?php

namespace ContentStash\Core\Attribute;

use ContentStash\Core\Helpers\ArrayHelper;

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
    public function getMigrationDefinition(): array
    {
        return ArrayHelper::mergeRecursiveDistinct(parent::getMigrationDefinition(), [
            'name' => 'boolean(\'{{name}}\')',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getFormSchema(): array
    {
        return array_merge(parent::getFormSchema(), [
            // 'defaultValue' => [
            //     'type' => 'boolean',
            //     'label' => 'attribute.type.defaultValue.label',
            //     'component' => 'switch',
            // ],
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getEntryFormSchema(): array
    {
        return [
            'type' => 'boolean',
            'component' => 'switch',
        ];
    }
}
