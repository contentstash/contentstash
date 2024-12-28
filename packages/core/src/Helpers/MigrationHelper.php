<?php

namespace ContentStash\Core\Helpers;

class MigrationHelper
{
    /**
     * Generate a table name from a model name.
     */
    public static function generateTableName(string $model): string
    {
        return strtolower($model).'s';
    }

    /**
     * Generate a migration file name from a model name.
     */
    public static function generateMigrationFileName(string $model, string $action = 'create'): string
    {
        return date('Y_m_d_His').'_'.$action.'_'.self::generateTableName($model).'_table.php';
    }

    /**
     * Generate migration file
     */
    public static function generateMigrationFile(string $model, array $attributes, string $action = 'create'): void
    {
        // load stub
        $stub = file_get_contents(__DIR__.'/../Stubs/migration.stub');

        // generate MigrationUp

        // generate MigrationDown

        // save migration file
        $migrationFileName = self::generateMigrationFileName($model, $action);
        $migrationFilePath = database_path('migrations/'.$migrationFileName);
        file_put_contents($migrationFilePath, $stub);

    }
}
