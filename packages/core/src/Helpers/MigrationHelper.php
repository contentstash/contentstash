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

        // get current model attributes
        $modelInfo = ModelInfoHelper::forModel($model);

        // parse $modelInfo->toArray()['attributes'] to object format
        $attributesArray = json_decode(json_encode($modelInfo->toArray()['attributes']), true);

        $currentModelAttributes = [];
        foreach ($attributesArray as $attribute) {
            $currentModelAttributes[$attribute['name']] = $attribute;
            $currentModelAttributes[$attribute['name']]['attributeType'] = $attribute['attributeType']['name'];
            unset($currentModelAttributes[$attribute['name']]['locked']);
        }

        // generate migrations
        $migration = self::generateMigrationByModelAttributes($attributes, $currentModelAttributes);

        // replace placeholders
        $stub = str_replace('{{MigrationUp}}', implode(";\n", $migration['up']), $stub);
        $stub = str_replace('{{MigrationDown}}', implode(";\n", $migration['down']), $stub);

        // save migration file
        $migrationFileName = self::generateMigrationFileName($model, $action);
        $migrationFilePath = database_path('migrations/'.$migrationFileName);

        dd($attributes, $migrationFilePath, $stub);
        // file_put_contents($migrationFilePath, $stub);

    }

    /**
     * Get new attributes.
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
     * Get deleted attributes.
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
     * Get updated attributes.
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
     * Generate new attributes migration.
     */
    public static function generateNewAttributesMigration(array $newModelAttributes, array $currentModelAttributes = []): array
    {
        $result = [
            'up' => [],
            'down' => [],
        ];

        $newAttributes = self::getNewAttributesByModelAttributes($newModelAttributes, $currentModelAttributes);
        foreach ($newAttributes as $attribute) {
            $migration = self::processNewAttributeMigration($attribute);
            $result['up'] = array_merge($result['up'], $migration['up']);
            $result['down'] = array_merge($result['down'], $migration['down']);
        }

        return $result;
    }

    /**
     * Generate updated attributes migration.
     */
    public static function generateUpdatedAttributesMigration(array $newModelAttributes, array $currentModelAttributes = []): array
    {
        $result = [
            'up' => [],
            'down' => [],
        ];

        $updatedAttributes = self::getUpdatedAttributesByModelAttributes($newModelAttributes, $currentModelAttributes);
        foreach ($updatedAttributes as $attribute) {
            $migration = self::processUpdatedAttributeMigration($attribute);
            $result['up'] = array_merge($result['up'], $migration['up']);
            $result['down'] = array_merge($result['down'], $migration['down']);
        }

        return $result;
    }

    /**
     * Generate deleted attributes migration.
     */
    public static function generateDeletedAttributesMigration(array $newModelAttributes, array $currentModelAttributes = []): array
    {
        $result = [
            'up' => [],
            'down' => [],
        ];

        $deletedAttributes = self::getDeletedAttributesByModelAttributes($newModelAttributes, $currentModelAttributes);
        foreach ($deletedAttributes as $attribute) {
            $migration = self::processDeletedAttributeMigration($attribute);
            $result['up'] = array_merge($result['up'], $migration['up']);
            $result['down'] = array_merge($result['down'], $migration['down']);
        }

        return $result;
    }

    /**
     * Generate migrations.
     */
    public static function generateMigrationByModelAttributes(array $newModelAttributes, array $currentModelAttributes = []): array
    {
        $result = [
            'up' => [],
            'down' => [],
        ];

        // handle new attributes
        $newAttributesMigration = self::generateNewAttributesMigration($newModelAttributes, $currentModelAttributes);

        $result['up'] = array_merge($result['up'], $newAttributesMigration['up']);
        $result['down'] = array_merge($result['down'], $newAttributesMigration['down']);

        // handle updated attributes
        $updatedAttributesMigration = self::generateUpdatedAttributesMigration($newModelAttributes, $currentModelAttributes);
        $result['up'] = array_merge($result['up'], $updatedAttributesMigration['up']);
        $result['down'] = array_merge($result['down'], $updatedAttributesMigration['down']);

        // handle deleted attributes
        $deletedAttributesMigration = self::generateDeletedAttributesMigration($newModelAttributes, $currentModelAttributes);
        $result['up'] = array_merge($result['up'], $deletedAttributesMigration['up']);
        $result['down'] = array_merge($result['down'], $deletedAttributesMigration['down']);

        return $result;
    }

    /**
     * Pre-process attribute migration.
     */
    protected static function preProcessAttributeMigration(array $attribute): array
    {
        $attributeType = AttributeTypeRegistry::getByName($attribute['attributeType']);
        $migration = $attributeType->getMigrationColumn();

        // reorder migration keys to ensure 'name' comes first
        uksort($migration, function ($a, $b) {
            if ($a === 'name') {
                return -1;
            } elseif ($b === 'name') {
                return 1;
            }

            return strcmp($a, $b);
        });

        return [
            'attributeType' => $attributeType,
            'migration' => $migration,
        ];
    }

    /**
     * Process new attribute migration.
     */
    protected static function processNewAttributeMigration(array $attribute): array
    {
        $preProcessedAttribute = self::preProcessAttributeMigration($attribute);

        $result = [
            'up' => [],
            'down' => [],
        ];

        $up = '$table';
        $down = '$table'.self::ARROW_SYMBOL.'dropColumn(\'{{name}}\')';

        foreach ($preProcessedAttribute['migration'] as $column => $value) {
            if (is_array($value)) {
                if (! array_key_exists('up', $value)) {
                    dd($column, $value);
                }
                $up .= self::ARROW_SYMBOL.$value['up'];
            } else {
                $up .= self::ARROW_SYMBOL.$value;
            }
        }

        foreach ($attribute as $key => $value) {
            $up = self::replacePlaceholders($up, $key, $value);
            $down = self::replacePlaceholders($down, $key, $value);
        }

        $result['up'][] = $up;
        $result['down'][] = $down;

        return $result;
    }

    /**
     * Process updated attribute migration.
     */
    protected static function processUpdatedAttributeMigration(array $attributeDiff): array
    {
        $attribute = $attributeDiff['new'];
        $preProcessedAttribute = self::preProcessAttributeMigration($attribute);

        $result = [
            'up' => [],
            'down' => [],
        ];

        // check if name has changed
        if (array_key_exists('name', $attributeDiff['diff'])) {
            $result['up'][] = '$table->renameColumn(\''.$attributeDiff['old']['name'].'\', \''.$attribute['name'].'\')';
            $result['down'][] = '$table->renameColumn(\''.$attribute['name'].'\', \''.$attributeDiff['old']['name'].'\')';
        }

        // check if any other attribute has changed
        if (count(array_diff_key($attributeDiff['diff'], ['name' => ''])) > 0) {

            $up = '$table';
            $down = '$table';

            // add column getter by name
            if (is_array($preProcessedAttribute['migration']['name'])) {
                $up .= self::ARROW_SYMBOL.$preProcessedAttribute['migration']['name']['up'];
                $down .= self::ARROW_SYMBOL.$preProcessedAttribute['migration']['name']['up'];
            } else {
                $up .= self::ARROW_SYMBOL.$preProcessedAttribute['migration']['name'];
                $down .= self::ARROW_SYMBOL.$preProcessedAttribute['migration']['name'];
            }

            foreach ($preProcessedAttribute['migration'] as $column => $value) {
                if ($column === 'name') {
                    continue;
                }

                if (is_array($value)) {
                    $up .= self::ARROW_SYMBOL.$value['up'];
                    $down .= array_key_exists('down', $value) ? self::ARROW_SYMBOL.$value['down'] : self::ARROW_SYMBOL.$value['up'];
                } else {
                    $up .= self::ARROW_SYMBOL.$value;
                    $down .= self::ARROW_SYMBOL.$value;
                }
            }

            foreach ($attribute as $key => $value) {
                $up = self::replacePlaceholders($up, $key, $value);
                $down = self::replacePlaceholders($down, $key, $value);
            }

            $up .= self::ARROW_SYMBOL.'change()';
            $down .= self::ARROW_SYMBOL.'change()';

            $result['up'][] = $up;
            $result['down'][] = $down;
        }

        return $result;
    }

    /**
     * Process deleted attribute migration.
     */
    protected static function processDeletedAttributeMigration(array $attribute): array
    {
        $preProcessedAttribute = self::preProcessAttributeMigration($attribute);

        $result = [
            'up' => [],
            'down' => [],
        ];

        $up = '$table'.self::ARROW_SYMBOL.'dropColumn(\'{{name}}\')';
        $down = '$table';

        foreach ($preProcessedAttribute['migration'] as $column => $value) {
            if (is_array($value)) {
                $down .= self::ARROW_SYMBOL.$value['up'];
            } else {
                $down .= self::ARROW_SYMBOL.$value;
            }
        }

        foreach ($attribute as $key => $value) {
            $up = self::replacePlaceholders($up, $key, $value);
            $down = self::replacePlaceholders($down, $key, $value);
        }

        $result['up'][] = $up;
        $result['down'][] = $down;

        return $result;
    }

    /**
     * Replace placeholders in a migration string.
     */
    protected static function replacePlaceholders(string $migrationString, string $key, mixed $value): string
    {
        while (preg_match('/{{'.$key.'\|([^}]+)}}/', $migrationString, $matches)) {
            $type = $matches[1];
            settype($value, $type);
            $migrationString = str_replace($matches[0], var_export($value, true), $migrationString);
        }

        return str_replace('{{'.$key.'}}', $value, $migrationString);
    }
}
