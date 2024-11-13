<?php

namespace ContentStash\Core\Helpers;

class ModelSlugHelper
{
    /**
     * Generate a slug from a model name.
     */
    public static function generateSlug(string $model): string
    {
        return implode('--', array_map(function ($part) {
            return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $part));
        }, explode('\\', $model)));
    }

    /**
     * Parse a slug to a model name.
     */
    public static function parseSlug(string $slug): string
    {
        return implode('\\', array_map(function ($part) {
            return str_replace('-', '', ucwords($part, '-'));
        }, explode('--', $slug)));
    }
}
