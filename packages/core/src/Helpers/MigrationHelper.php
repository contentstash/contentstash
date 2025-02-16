<?php

namespace ContentStash\Core\Helpers;

use ContentStash\Core\Enums\MigrationFileAction;
use ContentStash\Core\Enums\ModelRolePermissionPrefix;

class MigrationHelper
{
    /**
     * Arrow symbol for migration files.
     */
    const ARROW_SYMBOL = '->';

    /**
     * Spacing for the migration file.
     */
    const SPACING = '        ';

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
            if (count($attributes) == 0) {
                throw new \Exception('Attributes are required for creating a migration file.');
            }

            return $timestamp.'_create_'.$tableName.'_table.php';
        } elseif ($action->value === MigrationFileAction::Delete->value) {
            if (count($oldAttributes) == 0) {
                throw new \Exception('Old attributes are required for deleting a migration file.');
            }

            return $timestamp.'_delete_'.$tableName.'_table.php';
        } else {
            // get attribute difference
            $attributeDifference = MigrationTableHelper::getAttributeDifference($attributes, $oldAttributes);
            if (count($attributeDifference) == 0) {
                throw new \Exception('Attributes are required for updating a migration file.');
            }

            $newAttributes = MigrationTableHelper::getNewTableAttributes($attributeDifference);
            $updatedAttributes = MigrationTableHelper::getUpdatedTableAttributes($attributeDifference);
            $deletedAttributes = MigrationTableHelper::getDeletedTableAttributes($attributeDifference);

            // check if attributeDifference are only added, updated or deleted or a combination of them
            // only one type:
            // - if max 3 attributeDifference are changed, the name should be include the attribute names (e.g. add_name_and_age_to_users_table)
            // - if more than 3 attributeDifference are changed, the name add "fields" to the name (e.g. add_fields_to_users_table)
            // combination of types:
            // - always use "update_fields_in_table_name" as name
            if (count($newAttributes) == count($attributeDifference)) {
                if (count($newAttributes) <= 3) {
                    $newAttributesNames = array_keys($newAttributes);

                    return $timestamp.'_add_'.implode('_and_', $newAttributesNames).'_to_'.$tableName.'_table.php';
                } else {
                    return $timestamp.'_add_fields_to_'.$tableName.'_table.php';
                }
            } elseif (count($updatedAttributes) == count($attributeDifference)) {
                if (count($updatedAttributes) <= 3) {
                    $updatedAttributesNames = array_keys($updatedAttributes);

                    return $timestamp.'_update_'.implode('_and_', $updatedAttributesNames).'_in_'.$tableName.'_table.php';
                } else {
                    return $timestamp.'_update_fields_in_'.$tableName.'_table.php';
                }
            } elseif (count($deletedAttributes) == count($attributeDifference)) {
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

        // set up and down
        $up = $table['up'];
        $down = $table['down'];

        // generate permission if needed
        if (in_array($action->value, [MigrationFileAction::Create->value, MigrationFileAction::Delete->value])) {
            $permission = self::generatePermissionMigration($tableName, $action);
            $up .= PHP_EOL.$permission['up'];
            $down .= PHP_EOL.$permission['down'];
        }

        // replace placeholders
        $stub = str_replace('{{MigrationUp}}', $up, $stub);
        $stub = str_replace('{{MigrationDown}}', $down, $stub);

        // get file name
        $fileName = self::getMigrationFileName($tableName, $action, $attributes, $oldAttributes);

        // get file path
        $filePath = database_path('migrations').'/'.$fileName;

        // save file
        file_put_contents($filePath, $stub);
    }

    /**
     * Generate migration for permissions on create and delete.
     */
    public static function generatePermissionMigration(
        string $tableName,
        MigrationFileAction $action = MigrationFileAction::Create): array
    {
        if (! in_array($action->value, [MigrationFileAction::Create->value, MigrationFileAction::Delete->value])) {
            throw new \Exception('Only create and delete actions are allowed for permission migrations.');
        }

        $create = '';
        $delete = '';

        // get model permission name
        $modelName = ModelHelper::getModelName($tableName);
        $modelPermissionName = ModelHelper::getModelPermissionName($modelName);

        // loop through permissions and generate migration
        foreach (ModelRolePermissionPrefix::cases() as $permission) {
            $permissionName = $permission->value.' '.$modelPermissionName;

            $create .= self::SPACING."\Spatie\Permission\Models\Permission::create(['name' => '$permissionName']);".PHP_EOL;
            $delete .= self::SPACING."\Spatie\Permission\Models\Permission::where('name', '$permissionName')->delete();".PHP_EOL;
        }

        // return up and down based on action
        if ($action->value === MigrationFileAction::Create->value) {
            return [
                'up' => $create,
                'down' => $delete,
            ];
        } else {
            return [
                'up' => $delete,
                'down' => $create,
            ];
        }
    }
}
