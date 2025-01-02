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
        $method = strtolower($action->value).'Table';
        $table = MigrationTableHelper::$method($tableName, $attributes, $oldAttributes);

        // replace placeholders
        $stub = str_replace('{{MigrationUp}}', $table['up'], $stub);
        $stub = str_replace('{{MigrationDown}}', $table['down'], $stub);

        return [
            'stub' => $stub,
        ];
    }
}
