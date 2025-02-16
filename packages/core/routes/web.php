<?php

use ContentStash\Core\Http\Controllers\AuthController;
use ContentStash\Core\Http\Controllers\DashboardController;
use ContentStash\Core\Http\Controllers\DashboardResourceBuilderController;
use ContentStash\Core\Http\Controllers\DashboardResourceController;
use ContentStash\Core\Http\Controllers\DashboardRoleController;
use ContentStash\Core\Http\Controllers\LanguageController;
use ContentStash\Core\Http\Middleware\DashboardAuth;
use ContentStash\Core\Http\Middleware\HandleInertiaDashboardRequests;
use ContentStash\Core\Http\Middleware\SyncRoles;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'as' => 'auth.',
        'prefix' => 'auth',
        'middleware' => ['web', HandleInertiaDashboardRequests::class, SyncRoles::class],
    ],
    function () {
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    }
);

Route::group(
    [
        'as' => 'dashboard.',
        'prefix' => 'dashboard',
        'middleware' => ['web', HandleInertiaDashboardRequests::class, DashboardAuth::class, SyncRoles::class],
    ],
    function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::group(
            [
                'as' => 'resources.',
                'prefix' => 'resources',
            ],
            function () {
                Route::group(
                    [
                        'as' => 'slug.',
                        'prefix' => '{slug}',
                    ],
                    function () {
                        Route::get('/', [DashboardResourceController::class, 'index'])->name('index');
                        Route::get('/create', [DashboardResourceController::class, 'create'])->name('create');
                        Route::post('/', [DashboardResourceController::class, 'store'])->name('store');

                        Route::group(
                            [
                                'as' => 'id.',
                                'prefix' => '{id}',
                            ], function () {
                                Route::get('/edit', [DashboardResourceController::class, 'edit'])->name('edit');
                                Route::put('/', [DashboardResourceController::class, 'update'])->name('update');
                                Route::delete('/', [DashboardResourceController::class, 'destroy'])->name('destroy');
                            }
                        );
                    }
                );
            }
        );

        Route::group(
            [
                'as' => 'resource-builder.',
                'prefix' => 'resource-builder',
            ],
            function () {
                Route::get('/create', [DashboardResourceBuilderController::class, 'create'])->name('create');
                Route::post('/', [DashboardResourceBuilderController::class, 'store'])->name('store');

                Route::group(
                    [
                        'as' => 'slug.',
                        'prefix' => '{slug}',
                    ],
                    function () {
                        Route::get('/', [DashboardResourceBuilderController::class, 'show'])->name('show');
                        Route::put('/', [DashboardResourceBuilderController::class, 'update'])->name('update');
                        Route::delete('/', [DashboardResourceBuilderController::class, 'destroy'])->name('destroy');
                    }
                );
            }
        );

        Route::group(
            [
                'as' => 'roles.',
                'prefix' => 'roles',
            ],
            function () {
                Route::get('/', [DashboardRoleController::class, 'index'])->name('index');
                // Route::get('/create', [DashboardRoleController::class, 'create'])->name('create');
                // Route::post('/', [DashboardRoleController::class, 'store'])->name('store');
                Route::get('/{role}/edit', [DashboardRoleController::class, 'edit'])->name('edit');
                Route::put('/{role}', [DashboardRoleController::class, 'update'])->name('update');
                // Route::delete('/{role}', [DashboardRoleController::class, 'destroy'])->name('destroy');
            }
        );
    }
);

Route::get('/translations/{locale}', [LanguageController::class, 'getTranslations']);
Route::get('/routes/', [\ContentStash\Core\Http\Controllers\RoutesController::class, 'index']);
