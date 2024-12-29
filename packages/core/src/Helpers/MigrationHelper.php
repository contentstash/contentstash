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

        dd($attributes, $migrationFilePath, $stub);
        // file_put_contents($migrationFilePath, $stub);

    }

    /**
     * Generate migrations by comparing the new model attributes with the current model attributes.
     */
    public static function generateMigrationByModelAttributes(array $newModelAttributes, array $currentModelAttributes = []): array
    {
        $migrationUp = [];
        $migrationDown = [];

        $newAttributes = self::getNewAttributes($newModelAttributes, $currentModelAttributes);
        $deletedAttributes = self::getDeletedAttributes($newModelAttributes, $currentModelAttributes);
        $updatedAttributes = self::getUpdatedAttributes($newModelAttributes, $currentModelAttributes);

        dd([
            'newModelAttributes' => $newModelAttributes,
            'currentModelAttributes' => $currentModelAttributes,
            'newAttributes' => $newAttributes,
            'deletedAttributes' => $deletedAttributes,
            'updatedAttributes' => $updatedAttributes,
        ]);
    }

    /**
     * Get new attributes by comparing the new model attributes with the current model attributes.
     */
    public static function getNewAttributes(array $newModelAttributes, array $currentModelAttributes = []): array
    {
        $newAttributes = [];

        foreach ($newModelAttributes as $key => $value) {
            if (! array_key_exists($key, $currentModelAttributes)) {
                $newAttributes[$key] = $value;
            }
        }

        return $newAttributes;
    }

    /**
     * Get deleted attributes by comparing the new model attributes with the current model attributes.
     */
    public static function getDeletedAttributes(array $newModelAttributes, array $currentModelAttributes = []): array
    {
        $deletedAttributes = [];

        foreach ($currentModelAttributes as $key => $value) {
            if (! array_key_exists($key, $newModelAttributes)) {
                $deletedAttributes[$key] = $value;
            }
        }

        return $deletedAttributes;
    }

    /**
     * Get updated attributes by comparing the new model attributes with the current model attributes.
     */
    public static function getUpdatedAttributes(array $newModelAttributes, array $currentModelAttributes = []): array
    {
        $updatedAttributes = [];
        foreach ($newModelAttributes as $key => $value) {
            if (array_key_exists($key, $currentModelAttributes) && $value !== $currentModelAttributes[$key]) {
                $updatedAttributes[$key] = [
                    'old' => $currentModelAttributes[$key],
                    'new' => $value,
                    'diff' => array_diff_assoc($value, $currentModelAttributes[$key]),
                ];
            }
        }

        return $updatedAttributes;
    }
}
