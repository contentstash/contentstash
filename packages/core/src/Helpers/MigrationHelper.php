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
     * Generates a migration file for the given action.
     */
    public static function generateMigrationFile(
        string $tableName,
        array $attributes,
        array $oldAttributes = [],
        MigrationFileAction $action = MigrationFileAction::Create): array
    {
        // load stub file
        $stub = file_get_contents(__DIR__.'/../Stubs/migration.stub');

        // generate table based on action
        $method = 'generate'.ucfirst(strtolower($action->value)).'MigrationFile';
        $table = self::$method($tableName, $attributes, $oldAttributes);

        // replace placeholders
        $stub = str_replace('{{MigrationUp}}', $table['up'], $stub);
        $stub = str_replace('{{MigrationDown}}', $table['down'], $stub);

        return [
            'stub' => $stub,
        ];
    }

    /**
     * Generates a migration file for creating a new table.
     */
    public static function generateCreateMigrationFile(
        string $tableName,
        array $attributes): array
    {

        $table = MigrationTableHelper::createNewTable($tableName, $attributes);

        return $table;
    }

    /**
     * Generates a migration file for updating an existing table.
     */
    public static function generateUpdateMigrationFile(
        string $tableName,
        array $attributes,
        array $oldAttributes): array
    {
        // $table = MigrationTableHelper::updateTable($tableName, $attributes, $oldAttributes);

        // return $table;

        return [
            'up' => '',
            'down' => '',
        ];
    }

    /**
     * Generates a migration file for deleting a table.
     */
    public static function generateDeleteMigrationFile(
        string $tableName): array
    {
        // $table = MigrationTableHelper::deleteTable($tableName);

        // return $table;

        return [
            'up' => '',
            'down' => '',
        ];
    }
}
