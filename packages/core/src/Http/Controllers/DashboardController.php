<?php

namespace ContentStash\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
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
}
