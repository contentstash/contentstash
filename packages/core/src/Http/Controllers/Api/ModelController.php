<?php

namespace ContentStash\Core\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use ContentStash\Core\Helpers\ModelSlugHelper;

class ModelController extends Controller
{
    /**
     * Parse model by request.
     */
    public function parseModel(string $model): string
    {
        $model = ModelSlugHelper::parseSlug($model);
        if (! $model || ! class_exists($model)) {
            abort(404);
        }

        return $model;
    }

    /**
     * Get custom controller or default controller.
     */
    public function getController(string $model): string
    {
        $controller = str_replace('Models', 'Http\Controllers\Api', $model).'Controller';
        if (! class_exists($controller)) {
            $controller = 'ContentStash\Core\Http\Controllers\Api\BaseModelController';
        }

        return $controller;
    }

    /**
     * Call method from model controller by model.
     */
    public function callMethod(string $model, string $method, $resource = null)
    {
        $model = $this->parseModel($model);

        $controller = $this->getController($model);

        return app($controller)->$method($model, $resource);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $model)
    {
        return $this->callMethod($model, 'index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $model)
    {
        return $this->callMethod($model, 'store');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $model, $resource)
    {
        return $this->callMethod($model, 'show', $resource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $model, $resource)
    {
        return $this->callMethod($model, 'update', $resource);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $model, $resource)
    {
        return $this->callMethod($model, 'destroy', $resource);
    }
}
