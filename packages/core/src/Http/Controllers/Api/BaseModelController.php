<?php

namespace ContentStash\Core\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use ContentStash\Core\Http\Resources\ModelResource;

class BaseModelController extends Controller
{
    /**
     * Get policy by model.
     */
    public static function getPolicy(string $model)
    {
        $policy = str_replace('Models', 'Policies', $model).'Policy';
        if (! class_exists($policy)) {
            $policy = 'ContentStash\Core\Policies\BaseModelPolicy';
        }

        return $policy;
    }

    /**
     * Check if the user can perform the action.
     */
    public function can(string $model, string $method, $resource = null)
    {
        $policy = self::getPolicy($model);

        return app($policy)->$method($model, $resource);
    }

    /**
     * Authorize the request.
     */
    public function authorize(string $model, string $method, $resource = null)
    {
        $can = $this->can($model, $method, $resource);

        if ($can->denied()) {
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $model)
    {
        $this->authorize($model, 'viewAny');
        $model = app($model);

        return ModelResource::collection($model->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $model)
    {
        $this->authorize($model, 'create');
        $model = app($model);

        return ModelResource::make($model->create(request()->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $model, $resource)
    {
        $this->authorize($model, 'view', $resource);
        $model = app($model);

        return ModelResource::make($model->findOrFail($resource));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $model, $resource)
    {
        $this->authorize($model, 'update', $resource);
        $model = app($model);

        $model = $model->findOrFail($resource);
        $model->update(request()->all());

        return ModelResource::make($model);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $model, $resource)
    {
        $this->authorize($model, 'delete', $resource);

        $model = app($model);
        $model = $model->findOrFail($resource);
        $model->delete();

        return response()->noContent();
    }
}
