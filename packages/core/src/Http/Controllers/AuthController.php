<?php

namespace ContentStash\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    /**
     * Display the login page.
     */
    public function login(): Response
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Log the user in and redirect them to the dashboard.
     */
    public function authenticate(Request $request): Response|\Symfony\Component\HttpFoundation\Response
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return Inertia::location(route('dashboard.index'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out and redirect them to the login page.
     */
    public function logout(Request $request): Response|\Symfony\Component\HttpFoundation\Response
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Inertia::location(route('auth.login'));
    }
}
