<?php

namespace ContentStash\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Tighten\Ziggy\Ziggy;

class RoutesController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(): JsonResponse
    {
        return response()->json(new Ziggy);
    }
}
