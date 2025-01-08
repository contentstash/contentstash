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
    public function getMigrationDefinition(): array
    {
        return ArrayHelper::mergeRecursiveDistinct(parent::getMigrationDefinition(), [
            'name' => 'bigInteger(\'{{name}}\')',
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
