<?php

namespace ContentStash\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use AttributeTypeRegistry;
use ContentStash\Core\Helpers\ModelSlugHelper;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\ModelInfo\ModelInfo;

class DashboardResourceBuilderController extends Controller
{
    /**
     * Protected fields of protected models.
     *
     * @var array
     */
    protected $protectedFields = [
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
     * Shows the resource builder for the given model.
     */
    public function show(string $slug): Response
    {
        $model = ModelSlugHelper::parseSlug($slug);
        $modelInfo = ModelInfo::forModel($model);

        // check if model is protected
        if (array_key_exists($model, $this->protectedFields)) {
            $modelInfo->attributes = $modelInfo->attributes->map(function ($attribute) use ($model) {
                $attributeArray = (array) $attribute;
                if (in_array($attribute->name, $this->protectedFields[$model])) {
                    $attributeArray['locked'] = true;
                }

                return (object) $attributeArray;
            });
        }

        // set attribute types
        $modelInfo->attributes->each(function ($attribute) {
            $attribute->attributeType = AttributeTypeRegistry::get($attribute->phpType, $attribute->type);
        });

        return Inertia::render('Dashboard/ResourceBuilder/[slug]/Show', [
            'model' => $model,
            'modelInfo' => $modelInfo,
        ]);
    }
}
