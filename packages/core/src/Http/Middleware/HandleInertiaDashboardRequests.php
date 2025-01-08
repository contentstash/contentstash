<?php

namespace ContentStash\Core\Http\Middleware;

use AttributeTypeRegistry;
use ContentStash\Core\Helpers\ModelSlugHelper;
use Illuminate\Http\Request;
use Spatie\ModelInfo\ModelFinder;

class HandleInertiaDashboardRequests extends HandleInertiaRequests
{
    /**
     * {@inheritDoc}
     */
    public function share(Request $request): array
    {
        $models = ModelFinder::all();

        return array_merge(parent::share($request), [
            'resources' => collect($models)->map(function ($model) {
                return [
                    'class' => $model,
                    'title' => explode('\\', $model)[count(explode('\\', $model)) - 1],
                    'slug' => ModelSlugHelper::generateSlug($model),
                ];
            })->sortBy('title')->values()->toArray(),
            'attributeTypes' => AttributeTypeRegistry::allAsArray(),
        ]);
    }
}
