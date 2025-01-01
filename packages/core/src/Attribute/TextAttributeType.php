<?php

namespace ContentStash\Core\Attribute;

use ContentStash\Core\Helpers\ArrayHelper;

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
    public function getMigrationColumn(): array
    {
        return ArrayHelper::mergeRecursiveDistinct(parent::getMigrationColumn(), [
            'name' => [
                'up' => 'text(\'{{name}}\')',
            ],
        ]);
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
                'component' => 'textarea',
            ],
        ]);
    }
}
