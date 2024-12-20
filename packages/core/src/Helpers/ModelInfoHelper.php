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
        if (array_key_exists($model, self::$protectedFields)) {
            $modelInfo->attributes = $modelInfo->attributes->map(function ($attribute) use ($model) {
                $attributeArray = (array) $attribute;
                if (in_array($attribute->name, self::$protectedFields[$model])) {
                    $attributeArray['locked'] = true;
                }

                return (object) $attributeArray;
            });
        }

        // set attribute types
        $modelInfo->attributes->each(function ($attribute) {
            $attribute->attributeType = AttributeTypeRegistry::get($attribute->phpType, $attribute->type)?->toArray();
        });

        return $modelInfo;
    }
}
