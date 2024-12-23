<?php

namespace ContentStash\Core\Attribute;

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
    public function getMigrationColumn(): string
    {
        return "\$table->bigInteger('{{name}}')";
    }

    /**
     * {@inheritDoc}
     */
    public function getValidationRules(): array
    {
        return ['required', 'integer'];
    }
}
