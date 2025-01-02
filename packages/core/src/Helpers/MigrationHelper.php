<?php

namespace ContentStash\Core\Helpers;

use ContentStash\Core\Enums\MigrationFileAction;

class MigrationHelper
{
    /**
     * Arrow symbol for migration files.
     */
    const ARROW_SYMBOL = '->';

    /**
     * Get migration file name.
     */
    public static function getMigrationFileName(
        string $tableName,
        MigrationFileAction $action = MigrationFileAction::Create,
        array $attributes = [],
        array $oldAttributes = [], ): string
    {
        $timestamp = date('Y_m_d_His');

        if ($action->value === MigrationFileAction::Create->value) {
            return $timestamp.'_create_'.$tableName.'_table.php';
        } elseif ($action->value === MigrationFileAction::Delete->value) {
            return $timestamp.'_delete_'.$tableName.'_table.php';
        } else {
            // get attribute difference
            $attributeDifference = MigrationTableHelper::getAttributeDifference($attributes, $oldAttributes);

            $newAttributes = MigrationTableHelper::getNewTableAttributes($attributeDifference);
            $updatedAttributes = MigrationTableHelper::getUpdatedTableAttributes($attributeDifference);
            $deletedAttributes = MigrationTableHelper::getDeletedTableAttributes($attributeDifference);

            // check if attributes are only added, updated or deleted or a combination of them
            // only one type:
            // - if max 3 attributes are changed, the name should be include the attribute names (e.g. add_name_and_age_to_users_table)
            // - if more than 3 attributes are changed, the name add "fields" to the name (e.g. add_fields_to_users_table)
            // combination of types:
            // - always use "update_fields_in_table_name" as name
            if (count($newAttributes) == count($attributes)) {
                if (count($newAttributes) <= 3) {
                    $newAttributesNames = array_keys($newAttributes);

                    return $timestamp.'_add_'.implode('_and_', $newAttributesNames).'_to_'.$tableName.'_table.php';
                } else {
                    return $timestamp.'_add_fields_to_'.$tableName.'_table.php';
                }
            } elseif (count($updatedAttributes) == count($attributes)) {
                if (count($updatedAttributes) <= 3) {
                    $updatedAttributesNames = array_keys($updatedAttributes);

                    return $timestamp.'_update_'.implode('_and_', $updatedAttributesNames).'_in_'.$tableName.'_table.php';
                } else {
                    return $timestamp.'_update_fields_in_'.$tableName.'_table.php';
                }
            } elseif (count($deletedAttributes) == count($attributes)) {
                if (count($deletedAttributes) <= 3) {
                    $deletedAttributesNames = array_keys($deletedAttributes);

                    return $timestamp.'_remove_'.implode('_and_', $deletedAttributesNames).'_from_'.$tableName.'_table.php';
                } else {
                    return $timestamp.'_remove_fields_from_'.$tableName.'_table.php';
                }
            } else {
                return $timestamp.'_update_fields_in_'.$tableName.'_table.php';
            }
        }
    }

    /**
     * Generates a migration file for the given action.
     */
    public static function generateMigrationFile(
        string $tableName,
        array $attributes,
        array $oldAttributes = [],
        MigrationFileAction $action = MigrationFileAction::Create): void
    {
        // load stub file
        $stub = file_get_contents(__DIR__.'/../Stubs/migration.stub');

        // generate table based on action
        $method = strtolower($action->value).'Table';
        $table = MigrationTableHelper::$method($tableName, $attributes, $oldAttributes);

        // replace placeholders
        $stub = str_replace('{{MigrationUp}}', $table['up'], $stub);
        $stub = str_replace('{{MigrationDown}}', $table['down'], $stub);

        // get file name
        $fileName = self::getMigrationFileName($tableName, $action, $attributes, $oldAttributes);

        // get file path
        $filePath = database_path('migrations').'/'.$fileName;

        // save file
        file_put_contents($filePath, $stub);
    }
}
