<?php

namespace ContentStash\Core\Attribute;

use ContentStash\Core\Helpers\ArrayHelper;

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
    public function getMigrationDefinition(): array
    {
        return ArrayHelper::mergeRecursiveDistinct(parent::getMigrationDefinition(), [
            'name' => 'json(\'{{name}}\')',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getCast(): ?string
    {
        return 'array';
    }

    /**
     * {@inheritDoc}
     */
    public function getFormSchema(): array
    {
        return array_merge(parent::getFormSchema(), [
            // 'defaultValue' => [
            //     'type' => 'json',
            //     'label' => 'attribute.type.defaultValue.label',
            //     'component' => 'textarea',
            //     'defaultValue' => '{}',
            // ],
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getEntryFormSchema(): array
    {
        return [
            'type' => 'json',
            'component' => 'textarea',
        ];
    }
}
