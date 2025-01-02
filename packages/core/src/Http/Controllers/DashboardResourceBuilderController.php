<?php

namespace ContentStash\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use ContentStash\Core\Enums\MigrationFileAction;
use ContentStash\Core\Helpers\MigrationHelper;
use ContentStash\Core\Helpers\ModelInfoHelper;
use ContentStash\Core\Helpers\ModelSlugHelper;
use ContentStash\Core\Http\Requests\StoreResourceRequest;
use ContentStash\Core\Http\Requests\UpdateResourceRequest;
use Illuminate\Http\RedirectResponse;
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
    public function update(UpdateResourceRequest $request, string $slug): Response|RedirectResponse
    {
        $model = ModelSlugHelper::parseSlug($slug);
        $modelInfo = ModelInfoHelper::forModel($model);
        $modelAttributes = ModelInfoHelper::getAttributesForModel($model);

        try {
            MigrationHelper::generateMigrationFile(
                $modelInfo->tableName,
                $request->input('data'),
                $modelAttributes,
                MigrationFileAction::Update
            );
        } catch (\Exception $e) {
            return to_route('dashboard.resource-builder.slug.show', ['slug' => $slug])
                ->with('flash.error', [
                    'title' => 'An error occurred while creating the migration file.',
                    'description' => $e->getMessage(),
                ]);
        }

        return to_route('dashboard.resource-builder.slug.show', ['slug' => $slug])
            ->with('flash.success', [
                'title' => 'Migration file created successfully.',
                'description' => 'The migration file has been created successfully.',
            ]);
    }
}
