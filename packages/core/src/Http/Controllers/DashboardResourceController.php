<?php

namespace ContentStash\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use ContentStash\Core\Helpers\ModelInfoHelper;
use ContentStash\Core\Helpers\ModelSlugHelper;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardResourceController extends Controller
{
    /**
     * Shows the resource entry list.
     */
    public function index(string $slug): Response
    {
        $model = ModelSlugHelper::parseSlug($slug);
        $modelInfo = ModelInfoHelper::forModel($model);

        $items = $model::paginate(100);

        return Inertia::render('Dashboard/Resources/[slug]/Index', [
            'model' => $model,
            'modelInfo' => $modelInfo,
            'items' => $items,
            'slug' => $slug,
        ]);
    }

    /**
     * Shows the resource entry creation form.
     */
    public function create(string $slug): Response
    {
        $model = ModelSlugHelper::parseSlug($slug);
        $modelInfo = ModelInfoHelper::forModel($model);

        return Inertia::render('Dashboard/Resources/[slug]/Create', [
            'model' => $model,
            'modelInfo' => $modelInfo,
            'slug' => $slug,
        ]);
    }

    /**
     * Stores a new resource entry.
     */
    public function store(Request $request, string $slug): \Illuminate\Http\RedirectResponse
    {
        $model = ModelSlugHelper::parseSlug($slug);
        $model::unguard();
        $model::create($request->input('data'));
        $model::reguard();

        return to_route('dashboard.resources.slug.index', ['slug' => $slug])
            ->with('flash.success', [
                'title' => 'Item created',
            ]);
    }

    /**
     * Shows the resource entry edit form.
     */
    public function edit(string $slug, int $id): Response
    {
        $model = ModelSlugHelper::parseSlug($slug);
        $modelInfo = ModelInfoHelper::forModel($model);
        $item = $model::findOrFail($id);

        return Inertia::render('Dashboard/Resources/[slug]/[id]/Edit', [
            'model' => $model,
            'modelInfo' => $modelInfo,
            'id' => $id,
            'item' => $item,
            'slug' => $slug,
        ]);
    }

    /**
     * Updates a resource entry.
     */
    public function update(Request $request, string $slug, int $id): \Illuminate\Http\RedirectResponse
    {
        $model = ModelSlugHelper::parseSlug($slug);
        $model::unguard();
        $model::findOrFail($id)->update($request->input('data'));
        $model::reguard();

        return to_route('dashboard.resources.slug.index', ['slug' => $slug])
            ->with('flash.success', [
                'title' => 'Item updated',
            ]);
    }

    /**
     * Deletes a resource entry.
     */
    public function destroy(string $slug, int $id): \Illuminate\Http\RedirectResponse
    {
        $model = ModelSlugHelper::parseSlug($slug);
        $model::destroy($id);

        return to_route('dashboard.resources.slug.index', ['slug' => $slug])
            ->with('flash.success', [
                'title' => 'Item deleted',
            ]);
    }
}
