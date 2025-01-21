<?php

namespace ContentStash\Core\Attribute;

use ContentStash\Core\Enums\AttributeTypeFormat;
use ContentStash\Core\Helpers\ArrayHelper;

class TimestampAttributeType extends BaseAttributeType
{
    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'timestamp';
    }

    /**
     * {@inheritDoc}
     */
    public function getPhpType(): string
    {
        return '\Carbon\CarbonInterface';
    }

    /**
     * {@inheritDoc}
     */
    public function getIcon(): string
    {
        return 'CalendarClock';
    }

    /**
     * {@inheritDoc}
     */
    public function getClasses(): array
    {
        return [
            'badge' => 'bg-yellow-100 text-yellow-700',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getFormat(): AttributeTypeFormat
    {
        return AttributeTypeFormat::DateTime;
    }

    /**
     * {@inheritDoc}
     */
    public function getMigrationDefinition(): array
    {
        return ArrayHelper::mergeRecursiveDistinct(parent::getMigrationDefinition(), [
            'name' => 'timestamp(\'{{name}}\')',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getFormSchema(): array
    {
        return array_merge(parent::getFormSchema(), [
            // 'defaultValue' => [
            //     'type' => 'date',
            //     'label' => 'attribute.type.defaultValue.label',
            //     'placeholder' => 'attribute.type.defaultValue.placeholder',
            // ],
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getEntryFormSchema(): array
    {
        return [
            'type' => 'date',
        ];
    }
}
