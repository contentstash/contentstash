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
     * Generate migrations by comparing the new model attributes with the current model attributes.
     */
    public static function generateMigrationByModelAttributes(array $newModelAttributes, array $currentModelAttributes = []): array
    {
        $migrationUp = [];
        $migrationDown = [];

        $newAttributes = self::getNewAttributesByModelAttributes($newModelAttributes, $currentModelAttributes);
        $deletedAttributes = self::getDeletedAttributesByModelAttributes($newModelAttributes, $currentModelAttributes);
        $updatedAttributes = self::getUpdatedAttributesByModelAttributes($newModelAttributes, $currentModelAttributes);

        // handle new attributes
        foreach ($newAttributes as $attribute) {
            self::processAttributeMigration($attribute, $migrationUp, $migrationDown, true);
        }

        // handle deleted attributes
        foreach ($deletedAttributes as $attribute) {
            self::processAttributeMigration($attribute, $migrationDown, $migrationUp, true);
        }

        // handle updated attributes
        foreach ($updatedAttributes as $fieldName => $changes) {
            $oldAttribute = $changes['old'];
            $newAttribute = $changes['new'];

            // drop the old column in up migration
            $migrationUp[] = '$table'.self::ARROW_SYMBOL.'dropColumn(\''.$oldAttribute['name'].'\')';

            // add the new/updated column to up migration
            self::processAttributeMigration($newAttribute, $migrationUp, $migrationDown, true);

            // restore the old column in down migration
            self::processAttributeMigration($oldAttribute, $migrationDown, $migrationUp, true);
        }

        dd([
            'newAttributes' => $newAttributes,
            'deletedAttributes' => $deletedAttributes,
            'updatedAttributes' => $updatedAttributes,
            'migrationUp' => $migrationUp,
            'migrationDown' => $migrationDown,
        ]);

        return [
            'migrationUp' => $migrationUp,
            'migrationDown' => $migrationDown,
        ];
    }

    /**
     * Process attribute migration and handle placeholders.
     */
    private static function processAttributeMigration(array $attribute, array &$migrationUp, array &$migrationDown, bool $isNew): void
    {
        $attributeType = AttributeTypeRegistry::getByName($attribute['attributeType']);
        $migration = $attributeType->getMigrationColumn();

        // sort migration array by key
        uksort($migration, function ($a, $b) {
            if ($a === 'name') {
                return -1;
            } elseif ($b === 'name') {
                return 1;
            }

            return strcmp($a, $b);
        });

        // $operation = $isNew ? 'addColumn' : 'dropColumn';
        $up = '$table';
        $down = '$table';

        foreach ($migration as $column => $value) {
            if (is_array($value)) {
                $up .= self::ARROW_SYMBOL.$value['up'];
                $down .= self::ARROW_SYMBOL.$value['up'];
            } else {
                $up .= self::ARROW_SYMBOL.$value;
                $down .= self::ARROW_SYMBOL.$value;
            }
        }

        // replace placeholders in up and down migrations
        foreach ($attribute as $key => $value) {
            $up = self::replacePlaceholders($up, $key, $value);
            $down = self::replacePlaceholders($down, $key, $value);
        }

        if ($isNew) {
            $migrationUp[] = $up;
            $migrationDown[] = '$table'.self::ARROW_SYMBOL.'dropColumn(\''.$attribute['name'].'\')';
        } else {
            $migrationDown[] = $down;
            $migrationUp[] = '$table'.self::ARROW_SYMBOL.'dropColumn(\''.$attribute['name'].'\')';
        }
    }

    /**
     * Replace placeholders in a migration string.
     */
    private static function replacePlaceholders(string $migrationString, string $key, mixed $value): string
    {
        while (preg_match('/{{'.$key.'\|([^}]+)}}/', $migrationString, $matches)) {
            $type = $matches[1];
            settype($value, $type);
            $migrationString = str_replace($matches[0], var_export($value, true), $migrationString);
        }

        return str_replace('{{'.$key.'}}', $value, $migrationString);
    }
}
