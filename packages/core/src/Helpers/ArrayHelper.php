<?php

namespace ContentStash\Core\Helpers;

class ArrayHelper
{
    /**
     * Merges arrays recursively without converting strings to arrays.
     */
    public static function mergeRecursiveDistinct(...$arrays): array
    {
        $merged = [];

        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                if (isset($merged[$key]) && is_array($value) && is_array($merged[$key])) {
                    $merged[$key] = self::mergeRecursiveDistinct($merged[$key], $value);
                } else {
                    $merged[$key] = $value;
                }
            }
        }

        return $merged;
    }
}
