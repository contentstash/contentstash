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
    public function getFormSchema(): array
    {
        return array_merge(parent::getFormSchema(), [
            'defaultValue' => [
                'type' => 'number',
                'label' => 'attribute.type.defaultValue.label',
                'description' => 'attribute.type.defaultValue.description',
                'placeholder' => 'attribute.type.defaultValue.placeholder',
            ],
            'min' => [
                'type' => 'number',
                'label' => 'attribute.type.min.label',
                'description' => 'attribute.type.min.description',
            ],
            'max' => [
                'type' => 'number',
                'label' => 'attribute.type.max.label',
                'description' => 'attribute.type.max.description',
            ],
        ]);
    }
}
