<?php

namespace ContentStash\Core\Helpers;

use AttributeTypeRegistry;

class MigrationTableAttributeHelper
{
    /**
     * Spacing for the migration table attributes
     */
    const TABLE_ATTRIBUTE_SPACING = '          ';

    /**
     * End of line for the migration table attributes
     */
    const TABLE_ATTRIBUTE_EOL = ';'.PHP_EOL;

    /**
     * Get the filtered schema
     */
    public static function getFilteredSchema(array $schema): array
    {
        $filteredSchema = [];
        foreach ($schema as $key => $value) {
            if ($key === 'attributeType') {
                continue;
            }

            $filteredSchema[$key] = $value;
        }

        return $filteredSchema;
    }

    /**
     * Get the sorted schema
     */
    public static function getSortedSchema(array $schema): array
    {
        $sortedSchema = $schema;
        uksort($sortedSchema, function ($a, $b) {
            if ($a === 'name') {
                return -1;
            } elseif ($b === 'name') {
                return 1;
            }

            return strcmp($a, $b);
        });

        return $sortedSchema;
    }

    /**
     * Generates a migration attribute for the given schema.
     */
    public static function generateMigrationAttribute(array $schema): string
    {
        $result = self::TABLE_ATTRIBUTE_SPACING.'$table';
        $attributeType = AttributeTypeRegistry::getByName($schema['attributeType']);
        $schema = self::getSortedSchema(self::getFilteredSchema($schema));

        // loop through the schema, check for migration definition and apply it
        foreach ($schema as $key => $value) {
            $migrationDefinition = $attributeType->getMigrationDefinition();
            if (isset($migrationDefinition[$key])) {
                if (is_array($migrationDefinition[$key])) {
                    $result .= MigrationHelper::ARROW_SYMBOL.$migrationDefinition[$key]['up'];
                } else {
                    $result .= MigrationHelper::ARROW_SYMBOL.$migrationDefinition[$key];
                }
            }
        }

        // replace placeholders
        $result = self::replaceMigrationDefinitionPlaceholders($result, $schema);

        return $result;
    }

    /**
     * Replace the migration definition placeholders with the actual values
     */
    public static function replaceMigrationDefinitionPlaceholders(string $migrationString, array $schema): string
    {
        foreach ($schema as $key => $value) {
            while (preg_match('/{{'.$key.'\|([^}]+)}}/', $migrationString, $matches)) {
                $type = $matches[1];
                settype($value, $type);
                $migrationString = str_replace($matches[0], var_export($value, true), $migrationString);
            }

            $migrationString = str_replace('{{'.$key.'}}', $value, $migrationString);
        }

        return $migrationString;
    }

    /**
     * Get difference between two attribute schemas.
     */
    public static function getSchemaDifference(
        array $newSchema,
        array $oldSchema): array
    {
        $result = [];

        // get new and updated attributes
        foreach ($newSchema as $key => $value) {
            if (array_key_exists($key, $oldSchema) && $value !== $oldSchema[$key]) {
                $result['old'][$key] = $oldSchema[$key];
                $result['new'][$key] = $value;
            } elseif (! array_key_exists($key, $oldSchema)) {
                $result['new'][$key] = $value;
            }
        }

        // get deleted attributes
        foreach ($oldSchema as $key => $value) {
            if (! array_key_exists($key, $newSchema)) {
                $result['old'][$key] = $value;
            }
        }

        // keep attributeType for existing schema
        if (isset($result['new'])) {
            $result['new']['attributeType'] = $newSchema['attributeType'];
        }
        if (isset($result['old'])) {
            $result['old']['attributeType'] = $oldSchema['attributeType'];
        }

        return $result;
    }
}
