<?php

namespace ContentStash\Core\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class DashboardAuth extends Middleware
{
    /**
     *  {@inheritDoc}
     */
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            return route('auth.login');
        }
    }
}
