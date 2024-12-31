<?php

namespace ContentStash\Core\Helpers;

use AttributeTypeRegistry;

class MigrationHelper
{
    /**
     * Arrow symbol for migration files.
     */
    const ARROW_SYMBOL = '->';

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
     * Get new attributes by comparing the new model attributes with the current model attributes.
     */
    public static function getNewAttributesByModelAttributes(array $newModelAttributes, array $currentModelAttributes = []): array
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
    public static function getDeletedAttributesByModelAttributes(array $newModelAttributes, array $currentModelAttributes = []): array
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
    public static function getUpdatedAttributesByModelAttributes(array $newModelAttributes, array $currentModelAttributes = []): array
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

    /**
     * Process a single attribute for migration, replacing placeholders and appending to migrations.
     */
    private static function processAttributeMigration(array $attribute, array &$migrationUp, array &$migrationDown, bool $isNew = false): void
    {
        $attributeType = AttributeTypeRegistry::getByName($attribute['attributeType']);
        $migration = $attributeType->getMigrationColumn();

        // sort migration array by key (name first else alphabetical)
        uksort($migration, function ($a, $b) {
            if ($a === 'name') {
                return -1;
            } elseif ($b === 'name') {
                return 1;
            }

            return strcmp($a, $b);
        });

        $up = '$table';
        foreach ($migration as $column => $value) {
            if (is_array($value)) {
                $up .= self::ARROW_SYMBOL.$value['up'];
            } else {
                $up .= self::ARROW_SYMBOL.$value;
            }
        }

        // replace placeholders
        foreach ($attribute as $key => $value) {
            while (preg_match('/{{'.$key.'\|([^}]+)}}/', $up, $matches)) {
                $type = $matches[1];
                settype($value, $type);
                $up = str_replace($matches[0], var_export($value, true), $up);
            }
            $up = str_replace('{{'.$key.'}}', $value, $up);
        }

        $migrationUp[] = $up;

        if ($isNew) {
            $down = '$table'.self::ARROW_SYMBOL.'dropColumn(\''.$attribute['name'].'\')';
            $migrationDown[] = $down;
        }
    }

    /**
     * Generate migrations by comparing the new model attributes with the current model attributes.
     */
    public static function generateMigrationByModelAttributes(array $newModelAttributes, array $currentModelAttributes = []): array
    {
        $migrationUp = [];
        $migrationDown = [];

        $newAttributes = self::getNewAttributesByModelAttributes($newModelAttributes, $currentModelAttributes);
        $deletedAttributes = self::getDeletedAttributesByModelAttributes($newModelAttributes, $currentModelAttributes);
        $updatedAttributes = self::getUpdatedAttributesByModelAttributes($newModelAttributes, $currentModelAttributes);

        // generate migration for new attributes
        foreach ($newAttributes as $key => $attribute) {
            $attributeType = AttributeTypeRegistry::getByName($attribute['attributeType']);

            $migration = $attributeType->getMigrationColumn();

            // Handle new attributes
            foreach ($newAttributes as $key => $attribute) {
                self::processAttributeMigration($attribute, $migrationUp, $migrationDown, true);
            }

            // Handle deleted attributes
            foreach ($deletedAttributes as $key => $attribute) {
                $attributeType = AttributeTypeRegistry::getByName($attribute['attributeType']);
                $down = '$table'.self::ARROW_SYMBOL.'dropColumn(\''.$attribute['name'].'\')';
                $migrationDown[] = $down;
            }
        }

        // Handle deleted attributes
        foreach ($deletedAttributes as $key => $attribute) {
            $attributeType = AttributeTypeRegistry::getByName($attribute['attributeType']);
            $migration = $attributeType->getMigrationColumn();

            // Sort migration array by key
            uksort($migration, function ($a, $b) {
                if ($a === 'name') {
                    return -1;
                } elseif ($b === 'name') {
                    return 1;
                }

                return strcmp($a, $b);
            });

            // Add to up migration (drop column)
            $up = '$table'.self::ARROW_SYMBOL.'dropColumn(\''.$attribute['name'].'\')';
            $migrationUp[] = $up;

            // Add to down migration (restore column)
            $down = '$table';
            foreach ($migration as $column => $value) {
                if (is_array($value)) {
                    $down .= self::ARROW_SYMBOL.$value['up'];
                } else {
                    $down .= self::ARROW_SYMBOL.$value;
                }
            }

            // Replace placeholders
            foreach ($attribute as $key => $value) {
                while (preg_match('/{{'.$key.'\|([^}]+)}}/', $down, $matches)) {
                    $type = $matches[1];
                    settype($value, $type);
                    $down = str_replace($matches[0], var_export($value, true), $down);
                }
                $down = str_replace('{{'.$key.'}}', $value, $down);
            }

            $migrationDown[] = $down;
        }

        // Handle updated attributes
        foreach ($updatedAttributes as $fieldName => $changes) {
            $oldAttribute = $changes['old'];
            $newAttribute = $changes['new'];
            $diffs = $changes['diff'];

            // Drop the old column in up migration
            $migrationUp[] = '$table'.self::ARROW_SYMBOL.'dropColumn(\''.$oldAttribute['name'].'\')';

            // Add the new/updated column to up migration
            self::processAttributeMigration($newAttribute, $migrationUp, $migrationDown, true);

            // Restore the old column in down migration
            self::processAttributeMigration($oldAttribute, $migrationDown, $migrationUp, true);
        }

        dd([
            'newAttributes' => $newAttributes,
            'deletedAttributes' => $deletedAttributes,
            'updatedAttributes' => $updatedAttributes,
            'migrationUp' => $migrationUp,
            'migrationDown' => $migrationDown,
        ]);

    }
}
