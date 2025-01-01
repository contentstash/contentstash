<?php

namespace ContentStash\Core\Attribute;

use ContentStash\Core\Helpers\ArrayHelper;

class BigIntAttributeType extends IntAttributeType
{
    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'bigint';
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): ?string
    {
        return 'bigint';
    }

    /**
     * {@inheritDoc}
     */
    public function getMigrationColumn(): array
    {
        return ArrayHelper::mergeRecursiveDistinct(parent::getMigrationColumn(), [
            'name' => [
                'up' => 'bigInteger(\'{{name}}\')',
            ],
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getValidationRules(): array
    {
        return ['required', 'integer'];
    }
}
