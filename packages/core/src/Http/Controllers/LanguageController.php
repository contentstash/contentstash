<?php

namespace ContentStash\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use ContentStash\Core\Helpers\ArrayHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use PluginRegistry;

class LanguageController extends Controller
{
    /**
     * Get translations for a locale.
     */
    public function getTranslations(
        string $locale
    ): JsonResponse {
        $translations = [];
        $plugins = PluginRegistry::all();

        foreach ($plugins as $plugin) {
            $files = File::files("{$plugin->getLocalPath()}/{$locale}");
            foreach ($files as $file) {
                $pluginTranslations = json_decode(File::get($file), true);
                $translations = ArrayHelper::mergeRecursiveDistinct($translations, $pluginTranslations);
            }
        }

        return response()->json($translations);
    }
}
