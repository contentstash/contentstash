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
    // public function getFormComponent(): string
    // {
    //     return '<textarea :value="value" @input="updateValue($event.target.value)"></textarea>';  // Textarea für den Text-Typ
    // }
}
