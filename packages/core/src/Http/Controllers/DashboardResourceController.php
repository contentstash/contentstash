<?php

namespace ContentStash\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use ContentStash\Core\Helpers\ModelSlugHelper;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\ModelInfo\ModelInfo;

class DashboardResourceController extends Controller
{
    /**
     * Shows the resource for the given model.
     */
    public function show(string $slug): Response
    {
        $model = ModelSlugHelper::parseSlug($slug);
        $modelInfo = ModelInfo::forModel($model);

        $items = $model::all();

        return Inertia::render('Dashboard/Resources/[slug]/Show', [
            'model' => $model,
            'modelInfo' => $modelInfo,
            'items' => $items,
        ]);
    }
}
