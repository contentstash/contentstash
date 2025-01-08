<?php

namespace ContentStash\Core\Helpers;

use AttributeTypeRegistry;
use Spatie\ModelInfo\ModelInfo;

class ModelInfoHelper
{
    /**
     * Protected fields of protected models.
     *
     * @var array
     */
    protected static $protectedFields = [
        '*' => [
            'id',
        ],
        'App\Models\User' => [
            'id',
            'name',
            'email',
            'email_verified_at',
            'password',
            'remember_token',
            'created_at',
            'updated_at',
        ],
    ];

    /**
     * Get model info for a given model.
     */
    public static function forModel(string $model): ModelInfo
    {
        $modelInfo = ModelInfo::forModel($model);

        // check if model is protected
        $modelProtectedFields = self::$protectedFields['*'];
        if (array_key_exists($model, self::$protectedFields)) {
            $modelProtectedFields = array_merge($modelProtectedFields, self::$protectedFields[$model]);
        }

        $modelInfo->attributes = $modelInfo->attributes->map(function ($attribute) use ($modelProtectedFields) {
            $attributeArray = (array) $attribute;
            if (in_array($attribute->name, $modelProtectedFields)) {
                $attributeArray['locked'] = true;
            }

            // set defaultValue to null
            $attributeArray['defaultValue'] = null;

            return (object) $attributeArray;
        });

        // set attribute types
        $modelInfo->attributes->each(function ($attribute) {
            $attribute->attributeType = AttributeTypeRegistry::get($attribute->phpType, $attribute->type)?->toArray();
        });

        return $modelInfo;
    }

    /**
     * Get attributes for a given model (with flat attributeTypes).
     */
    public static function getAttributesForModel(string $model): array
    {
        return self::forModel($model)->attributes->map(function ($attribute) {
            $attributeArray = (array) $attribute;
            $attributeArray['attributeType'] = $attribute->attributeType['name'];
            unset($attributeArray['locked']);

            return $attributeArray;
        })
            ->keyBy('name')
            ->toArray();
    }
}
