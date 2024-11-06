<?php

namespace ContentStash\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class LanguageController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(): Response
    {
        return Inertia::render('Dashboard/Index');
    }

    /**
     * Display the dashboard 2.
     */
    public function index2(): Response
    {
        return Inertia::render('Dashboard/Index2');
    }

    public function getTranslations(
        string $locale
    ): JsonResponse {
        $translations = [];

        foreach ($GLOBALS['CONTENTSTASH_PLUGINS'] as $plugin) {
            $files = File::files("{$plugin->getLocalPath()}/{$locale}");
            foreach ($files as $file) {
                $pluginTranslations = json_decode(File::get($file), true);
                $translations = array_merge_recursive($translations, $pluginTranslations);
            }
        }

        return response()->json($translations);
    }
}
