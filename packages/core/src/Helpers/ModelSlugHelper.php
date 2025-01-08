<?php

namespace ContentStash\Core\Helpers;

class ModelSlugHelper
{
    /**
     * Generate a slug from a model name.
     */
    public static function generateSlug(string $model): string
    {
        return strtolower(
            preg_replace(
                '/(?<!^)[A-Z]/',
                '-$0',
                basename(str_replace('\\', '/', $model))
            )
        );

        // TODO: Unsure which url format i want to use
        // return implode('--', array_map(function ($part) {
        //     return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $part));
        // }, explode('\\', $model)));
    }

    /**
     * Parse a slug to a model name.
     */
    public static function parseSlug(string $slug): string
    {
        return 'App\\Models\\'.str_replace('-', '', ucwords($slug, '-'));

        // TODO: Unsure which url format i want to use
        // return implode('\\', array_map(function ($part) {
        //     return str_replace('-', '', ucwords($part, '-'));
        // }, explode('--', $slug)));
    }
}
