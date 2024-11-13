<?php

namespace ContentStash\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use ContentStash\Core\Helpers\ModelSlugHelper;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\ModelInfo\ModelInfo;

class DashboardResourceBuilderController extends Controller
{
    /**
     * Shows the resource builder for the given model.
     */
    public function show(string $slug): Response
    {
        $model = ModelSlugHelper::parseSlug($slug);
        $modelInfo = ModelInfo::forModel($model);

        return Inertia::render('Dashboard/ResourceBuilder/[slug]/Show', [
            'model' => $model,
            'modelInfo' => $modelInfo,
        ]);
    }
}
