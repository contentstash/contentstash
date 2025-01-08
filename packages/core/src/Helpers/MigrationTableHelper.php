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

        return [
            'up' => $up,
            'down' => $down,
        ];
    }

    /**
     * Get new table attributes.
     */
    public static function getNewTableAttributes(
        array $attributeDifference): array
    {
        return array_filter($attributeDifference, function ($value) {
            return ! array_key_exists('old', $value) && array_key_exists('new', $value);
        });
    }

    /**
     * Get updated table attributes.
     */
    public static function getUpdatedTableAttributes(
        array $attributeDifference): array
    {
        return array_filter($attributeDifference, function ($value) {
            return array_key_exists('old', $value) && array_key_exists('new', $value);
        });
    }

    /**
     * Get deleted table attributes.
     */
    public static function getDeletedTableAttributes(
        array $attributeDifference): array
    {
        return array_filter($attributeDifference, function ($value) {
            return array_key_exists('old', $value) && ! array_key_exists('new', $value);
        });
    }

    /**
     * Generates a migration table for updating an existing table.
     */
    public static function updateTable(
        string $tableName,
        array $attributes,
        array $oldAttributes): array
    {
        // generate up method
        $up = self::TABLE_SPACING.'Schema::table(\''.$tableName.'\', function (Blueprint $table) {'.PHP_EOL;

        // get down method
        $down = self::TABLE_SPACING.'Schema::table(\''.$tableName.'\', function (Blueprint $table) {'.PHP_EOL;

        // get attribute difference
        $attributeDifference = self::getAttributeDifference($attributes, $oldAttributes);

        // get deleted attributes (have only old key) and generate up and down for them
        $deletedAttributes = self::getDeletedTableAttributes($attributeDifference);
        foreach ($deletedAttributes as $key => $value) {
            $up .= MigrationTableAttributeHelper::TABLE_ATTRIBUTE_SPACING.'$table->dropColumn(\''.$key.'\');'.PHP_EOL;
        }
        foreach ($deletedAttributes as $key => $value) {
            $down .= self::generateMigrationAttribute($oldAttributes[$key]);
        }

        // update attributes (have both old and new key) and generate up and down for them
        $updatedAttributes = self::getUpdatedTableAttributes($attributeDifference);
        foreach ($updatedAttributes as $key => $value) {
            // check if name has changed
            if ($value['old']['name'] !== $value['new']['name']) {
                $up .= MigrationTableAttributeHelper::TABLE_ATTRIBUTE_SPACING.'$table->renameColumn(\''.$value['old']['name'].'\', \''.$value['new']['name'].'\');'.PHP_EOL;

                continue;
            }

            $up .= self::generateMigrationAttribute($value['new']);
        }
        foreach ($updatedAttributes as $key => $value) {
            if ($value['old']['name'] !== $value['new']['name']) {
                $down .= MigrationTableAttributeHelper::TABLE_ATTRIBUTE_SPACING.'$table->renameColumn(\''.$value['new']['name'].'\', \''.$value['old']['name'].'\');'.PHP_EOL;

                continue;
            }
            $down .= self::generateMigrationAttribute($value['old']);
        }

        // add attributes (have only new key) and generate up and down for them
        $newAttributes = self::getNewTableAttributes($attributeDifference);
        foreach ($newAttributes as $key => $value) {
            $up .= self::generateMigrationAttribute($value['new']);
        }
        foreach ($newAttributes as $key => $value) {
            $down .= MigrationTableAttributeHelper::TABLE_ATTRIBUTE_SPACING.'$table->dropColumn(\''.$key.'\');'.PHP_EOL;
        }

        // append end to up and down
        $up .= self::TABLE_SPACING.'});';
        $down .= self::TABLE_SPACING.'});';

        return [
            'up' => $up,
            'down' => $down,
        ];
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
     * Generate migrations for the given attribute.
     */
    public static function generateMigrationAttribute(
        array $attribute): string
    {
        return MigrationTableAttributeHelper::generateMigrationAttribute($attribute).MigrationTableAttributeHelper::TABLE_ATTRIBUTE_EOL;
    }

    /**
     * Generate migrations for the given attributes.
     */
    public static function generateMigrationAttributes(
        array $attributes): string
    {
        $result = '';

        foreach ($attributes as $attribute) {
            $result .= self::generateMigrationAttribute($attribute);
        }

        return $result;
    }

    /**
     * Get difference between two attribute arrays.
     */
    public static function getAttributeDifference(
        array $newAttributes,
        array $oldAttributes): array
    {
        $result = [];

        // get all keys from both arrays
        $keys = array_values(array_unique(array_merge(array_keys($newAttributes), array_keys($oldAttributes))));

        foreach ($keys as $key) {
            $temp = MigrationTableAttributeHelper::getSchemaDifference($newAttributes[$key] ?? [], $oldAttributes[$key] ?? []);

            if (! empty($temp)) {
                $result[$key] = $temp;
            }
        }

        return $result;
    }
}
