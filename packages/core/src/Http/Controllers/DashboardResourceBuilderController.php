<?php

namespace ContentStash\Core\Http\Controllers;

use App\Http\Controllers\Controller;
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
        dd($slug, $request->all());
    }
}
