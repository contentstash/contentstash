<?php

namespace ContentStash\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use ContentStash\Core\Helpers\MigrationHelper;
use ContentStash\Core\Helpers\ModelInfoHelper;
use ContentStash\Core\Helpers\ModelSlugHelper;
use ContentStash\Core\Http\Requests\StoreResourceRequest;
use ContentStash\Core\Http\Requests\UpdateResourceRequest;
use Inertia\Inertia;
use Inertia\Response;

class DashboardResourceBuilderController extends Controller
{
    /**
     * Shows the resource builder for the given model.
     */
    public function show(string $slug): Response
    {
        $model = ModelSlugHelper::parseSlug($slug);
        $modelInfo = ModelInfoHelper::forModel($model);

        return Inertia::render('Dashboard/ResourceBuilder/[slug]/Show', [
            'slug' => $slug,
            'model' => $model,
            'modelInfo' => $modelInfo,
        ]);
    }

    /**
     * Stores the resource builder for the given model.
     */
    public function store(StoreResourceRequest $request): Response
    {
        dd($request->all());
    }

    /**
     * Updates the resource builder for the given model.
     */
    public function update(UpdateResourceRequest $request, string $slug): Response
    {
        $model = ModelSlugHelper::parseSlug($slug);
        $modelInfo = ModelInfoHelper::forModel($model);

        // parse $modelInfo->toArray()['attributes'] to object format
        $attributesArray = json_decode(json_encode($modelInfo->toArray()['attributes']), true);

        // $attributes = [];
        // foreach ($attributesArray as $attribute) {
        //     $attributes[$attribute['name']] = $attribute;
        //     $attributes[$attribute['name']]['attributeType'] = $attribute['attributeType']['name'];
        //     unset($attributes[$attribute['name']]['locked']);
        // }

        $inputData = $request->input('data');

        // MigrationHelper::generateMigrationByModelAttributes($inputData, $attributes);
        MigrationHelper::generateMigrationFile($model, $inputData, 'create');
    }
}
