<?php

namespace ContentStash\Core\Http\Middleware;

use Closure;
use ContentStash\Core\Enums\UserRole;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SyncRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (request()->user()) {
            if (! request()->user()->hasRole(UserRole::EVERYONE->value)) {
                request()->user()->assignRole(UserRole::EVERYONE->value);
            }
            if (! request()->user()->hasRole(UserRole::USER->value)) {
                request()->user()->assignRole(UserRole::USER->value);
            }
        }

        return $next($request);
    }
}
