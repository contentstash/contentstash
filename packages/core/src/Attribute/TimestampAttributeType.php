<?php

namespace ContentStash\Core\Attribute;

use ContentStash\Core\Enums\AttributeTypeFormat;

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
    public function getMigrationColumn(): string
    {
        return "\$table->timestamp('{{name}}')";
    }

    /**
     * {@inheritDoc}
     */
    public function getValidationRules(): array
    {
        return ['required', 'date'];
    }

    /**
     * {@inheritDoc}
     */
    public function getFormSchema(): array
    {
        return array_merge(parent::getFormSchema(), [
            'default' => [
                'type' => 'date',
                'label' => 'attribute.type.default.label',
                'description' => 'attribute.type.default.description',
                'placeholder' => 'attribute.type.default.placeholder',
            ],
        ]);
    }
}
