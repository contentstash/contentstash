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
     * Display the login page.
     */
    public function login(): Response
    {
        return Inertia::render('Dashboard/Login');
    }
}
