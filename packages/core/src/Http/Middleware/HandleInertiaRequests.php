<?php

namespace ContentStash\Core\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'contentstash::app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'user' => function () use ($request) {
                return $request->user()
                    ?
                        $request->user()->only('id', 'name', 'email')
                    : [
                        'email' => 'contact@kirch.dev',
                        'first_name' => 'Titus',
                        'last_name' => 'Kirch',
                        'full_name' => 'Titus Kirch',
                        'avatar' => 'https://avatars.githubusercontent.com/u/16943133?v=4',
                    ];
            },
            'app' => [
                'name' => config('app.name'),
            ],
            'locale' => app()->getLocale(),

        ]);
    }
}
