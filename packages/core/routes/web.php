<?php

use ContentStash\Core\Http\Controllers\DashboardController;
use ContentStash\Core\Http\Controllers\DashboardResourceBuilderController;
use ContentStash\Core\Http\Controllers\DashboardResourceController;
use ContentStash\Core\Http\Controllers\LanguageController;
use ContentStash\Core\Http\Middleware\HandleInertiaDashboardRequests;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'as' => 'dashboard.',
        'prefix' => 'dashboard',
        'middleware' => ['web', HandleInertiaDashboardRequests::class],
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

        Route::group(
            [
                'as' => 'test.',
                'prefix' => 'test',
            ],
            function () {
                Route::get('/', [DashboardController::class, 'index2'])->name('index');
                Route::get('/test', [DashboardController::class, 'index'])->name('test');

                Route::group(
                    [
                        'as' => 'foo.',
                        'prefix' => 'foo',
                    ],
                    function () {
                        Route::get('/', [DashboardController::class, 'index'])->name('index');
                        Route::get('/bar', [DashboardController::class, 'index2'])->name('bar');
                    }
                );
            }
        );
    }
);

Route::get('/translations/{locale}', [LanguageController::class, 'getTranslations']);
Route::get('/routes/', [\ContentStash\Core\Http\Controllers\RoutesController::class, 'index']);
