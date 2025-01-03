<?php

namespace ContentStash\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Artisan;
use ContentStash\Core\Enums\MigrationFileAction;
use ContentStash\Core\Helpers\MigrationHelper;
use ContentStash\Core\Helpers\ModelHelper;
use ContentStash\Core\Helpers\ModelInfoHelper;
use ContentStash\Core\Helpers\ModelSlugHelper;
use ContentStash\Core\Http\Requests\StoreResourceRequest;
use ContentStash\Core\Http\Requests\UpdateResourceRequest;
use Inertia\Inertia;
use Inertia\Response;
use Str;

class DashboardResourceBuilderController extends Controller
{
    /**
     * Shows the resource builder for a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Dashboard/ResourceBuilder/Create');
    }

    /**
     * Stores a new resource.
     */
    public function store(StoreResourceRequest $request): Response|\Symfony\Component\HttpFoundation\Response
    {
        $model = $request->input('model');
        $tableName = Str::snake(Str::pluralStudly($model));

        try {
            MigrationHelper::generateMigrationFile(
                $tableName,
                $request->input('data'),
                [],
                MigrationFileAction::Create
            );
        } catch (\Exception $e) {
            return to_route('dashboard.resource-builder.slug.show', ['slug' => $model])
                ->with('flash.error', [
                    'title' => 'An error occurred while creating the migration file.',
                    'description' => $e->getMessage(),
                ]);
        }

        // run migration
        Artisan::call('migrate');

        // create model file
        ModelHelper::generateModelFile(
            $tableName,
            $request->input('data')
        );

        session()->flash('flash.success', [
            'title' => 'Migration was successful.',
            'description' => 'A new migration file has been created and the migration has been run successfully.',
        ]);

        $slug = ModelSlugHelper::generateSlug('App\Models\\'.$model);

        return Inertia::location(route('dashboard.resource-builder.slug.show', ['slug' => $slug]));
    }

    /**
     * Shows the resource builder for the given resource.
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
     * Updates the resource.
     */
    public function update(UpdateResourceRequest $request, string $slug): Response|\Symfony\Component\HttpFoundation\Response
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

        // run migration
        Artisan::call('migrate');

        session()->flash('flash.success', [
            'title' => 'Migration was successful.',
            'description' => 'A new migration file has been created and the migration has been run successfully.',
        ]);

        return Inertia::location(route('dashboard.resource-builder.slug.show', ['slug' => $slug]));
    }

    /**
     * Deletes the resource.
     */
    public function destroy(string $slug): Response|\Symfony\Component\HttpFoundation\Response
    {
        $model = ModelSlugHelper::parseSlug($slug);
        $modelInfo = ModelInfoHelper::forModel($model);
        $modelAttributes = ModelInfoHelper::getAttributesForModel($model);

        try {
            MigrationHelper::generateMigrationFile(
                $modelInfo->tableName,
                [],
                $modelAttributes,
                MigrationFileAction::Delete
            );
        } catch (\Exception $e) {
            return to_route('dashboard.resource-builder.slug.show', ['slug' => $slug])
                ->with('flash.error', [
                    'title' => 'An error occurred while creating the migration file.',
                    'description' => $e->getMessage(),
                ]);
        }

        // run migration
        Artisan::call('migrate');

        // delete model file
        ModelHelper::deleteModelFile($modelInfo->tableName);

        session()->flash('flash.success', [
            'title' => 'Migration was successful.',
            'description' => 'A new migration file has been created and the migration has been run successfully.',
        ]);

        return Inertia::location(route('dashboard.index'));
    }
}
