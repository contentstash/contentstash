<?php

namespace ContentStash\Core\Helpers;

class MigrationTableHelper
{
    /**
     * Spacing for the migration table
     */
    const TABLE_SPACING = '        ';

    /**
     * Generates a migration table for the given model and input data
     */
    public static function createNewTable(
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
     * Generate migrations for the given attributes
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
