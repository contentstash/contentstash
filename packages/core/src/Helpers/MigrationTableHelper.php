<?php

namespace ContentStash\Core\Helpers;

class MigrationTableHelper
{
    /**
     * Spacing for the migration table
     */
    const TABLE_SPACING = '        ';

    /**
     * Generates a migration table for the given model and input data.
     */
    public static function createTable(
        string $tableName,
        array $attributes): array
    {
        // generate up method
        $up = self::TABLE_SPACING.'Schema::create(\''.$tableName.'\', function (Blueprint $table) {'.PHP_EOL;
        $up .= self::generateMigrationAttributes($attributes);
        $up .= self::TABLE_SPACING.'});';

        // generate down method
        $down = self::TABLE_SPACING.'Schema::dropIfExists(\''.$tableName.'\');';

        $result = [
            'up' => $up,
            'down' => $down,
        ];

        return $result;
    }

    /**
     * Generates a migration table for updating an existing table.
     */
    public static function updateTable(
        string $tableName,
        array $attributes,
        array $oldAttributes): array
    {
        $result = [
            'up' => '',
            'down' => '',
        ];

        return $result;
    }

    /**
     * Generate a migration table for deleting an table (uses create method and swaps up and down).
     */
    public static function deleteTable(
        string $tableName,
        array $attributes,
        array $oldAttributes): array
    {
        $table = self::createTable($tableName, $oldAttributes);

        return [
            'up' => $table['down'],
            'down' => $table['up'],
        ];
    }

    /**
     * Generate migrations for the given attributes.
     */
    public static function generateMigrationAttributes(
        array $attributes): string
    {
        $result = '';

        foreach ($attributes as $attribute) {
            $result .= MigrationTableAttributeHelper::generateMigrationAttribute($attribute).MigrationTableAttributeHelper::TABLE_ATTRIBUTE_EOL;
        }

        return $result;
    }
}
