<?php

namespace ContentStash\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use ContentStash\Core\Enums\MigrationFileAction;
use ContentStash\Core\Helpers\MigrationHelper;
use ContentStash\Core\Helpers\MigrationHelperOld;
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
        $modelAttributes = ModelInfoHelper::getAttributesForModel($model);

        $inputData = $request->input('data');

        $old = MigrationHelperOld::generateMigrationFile($model, $inputData, 'create');
        $newCreate = MigrationHelper::generateMigrationFile(
            $modelInfo->tableName,
            $inputData, $modelAttributes);
        $newUpdate = MigrationHelper::generateMigrationFile(
            $modelInfo->tableName,
            $inputData, $modelAttributes, MigrationFileAction::Update);
        $newDelete = MigrationHelper::generateMigrationFile(
            $modelInfo->tableName,
            $inputData, $modelAttributes, MigrationFileAction::Delete);

        dd($old, $newCreate, $newUpdate, $newDelete);

    }
}
