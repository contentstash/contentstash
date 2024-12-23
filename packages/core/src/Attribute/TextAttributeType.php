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
            'default' => [
                'type' => 'string',
                'label' => 'attribute.type.default.label',
                'description' => 'attribute.type.default.description',
                'placeholder' => 'attribute.type.default.placeholder',
                'component' => 'textarea',
            ],
        ]);
    }
}
