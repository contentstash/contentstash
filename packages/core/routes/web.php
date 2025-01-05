<?php

use ContentStash\Core\Http\Controllers\AuthController;
use ContentStash\Core\Http\Controllers\DashboardController;
use ContentStash\Core\Http\Controllers\DashboardResourceBuilderController;
use ContentStash\Core\Http\Controllers\DashboardResourceController;
use ContentStash\Core\Http\Controllers\LanguageController;
use ContentStash\Core\Http\Middleware\DashboardAuth;
use ContentStash\Core\Http\Middleware\HandleInertiaDashboardRequests;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'as' => 'auth.',
        'prefix' => 'auth',
        'middleware' => ['web', HandleInertiaDashboardRequests::class],
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
        'middleware' => ['web', HandleInertiaDashboardRequests::class, DashboardAuth::class],
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
                        Route::get('/', [DashboardResourceController::class, 'show'])->name('show');
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
    }
);

Route::get('/translations/{locale}', [LanguageController::class, 'getTranslations']);
Route::get('/routes/', [\ContentStash\Core\Http\Controllers\RoutesController::class, 'index']);
