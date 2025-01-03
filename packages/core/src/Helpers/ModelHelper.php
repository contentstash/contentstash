<?php

namespace ContentStash\Core\Helpers;

use AttributeTypeRegistry;
use Str;

class ModelHelper
{
    /**
     * Get model file name.
     */
    public static function getModelFileName(
        string $tableName,
    ): string {
        return Str::studly(Str::singular($tableName));
    }

    /**
     * Generates a model file for the given tabel.
     */
    public static function generateModelFile(
        string $tableName,
        array $attributes,
    ): void {
        // get file name and path
        $modelFileName = self::getModelFileName($tableName);
        $modelFilePath = app_path('Models').'/'.$modelFileName.'.php';

        // load stub file
        $stub = file_get_contents(__DIR__.'/../Stubs/model.stub');

        // replace placeholders
        $stub = str_replace('{{ModelName}}', $modelFileName, $stub);
        $casts = self::generateCastsArray($attributes);
        if (count($casts) > 0) {
            $stub = str_replace('{{Casts}}', self::castsArrayToString($casts), $stub);
        } else {
            $stub = str_replace('{{Casts}}', '', $stub);
        }

        // save file
        file_put_contents($modelFilePath, $stub);
    }

    /**
     * Delete a model file for the given tabel.
     */
    public static function deleteModelFile(
        string $tableName,
    ): void {
        $modelFileName = self::getModelFileName($tableName);

        $modelFilePath = app_path('Models').'/'.$modelFileName.'.php';

        if (file_exists($modelFilePath)) {
            unlink($modelFilePath);
        }
    }

    /**
     * Generate casts array for the given attributes.
     */
    public static function generateCastsArray(
        array $attributes,
    ): array {
        $casts = [];

        foreach ($attributes as $attribute) {
            $attributeType = AttributeTypeRegistry::getByName($attribute['attributeType']);
            if ($attributeType->getCast()) {
                $casts[$attribute['name']] = $attributeType->getCast();
            }
        }

        return $casts;
    }

    /**
     * Convert casts array to string.
     */
    public static function castsArrayToString(
        array $casts,
    ): string {
        $castsString = '';

        foreach ($casts as $key => $value) {
            $castsString .= '\''.$key.'\' => \''.$value.'\','.PHP_EOL;
        }

        return $castsString;
    }
}
