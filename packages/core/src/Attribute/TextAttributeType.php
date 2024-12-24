<?php

namespace ContentStash\Core\Attribute;

class TextAttributeType extends StringAttributeType
{
    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'text';
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): ?string
    {
        return 'text';
    }

    /**
     * {@inheritDoc}
     */
    public function getMigrationColumn(): string
    {
        return "\$table->text('{{name}}')";
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
                'description' => 'attribute.type.defaultValue.description',
                'placeholder' => 'attribute.type.defaultValue.placeholder',
                'component' => 'textarea',
            ],
        ]);
    }
}
