<?php

namespace ContentStash\Core\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use ContentStash\Core\Http\Resources\ModelResource;

class BaseModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $model)
    {
        $model = app($model);

        return ModelResource::collection($model->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $model)
    {
        $model = app($model);

        return ModelResource::make($model->create(request()->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $model, $resource)
    {
        $model = app($model);

        return ModelResource::make($model->findOrFail($resource));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $model, $resource)
    {
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
        $model = app($model);

        $model = $model->findOrFail($resource);

        $model->delete();

        return response()->noContent();
    }
}
