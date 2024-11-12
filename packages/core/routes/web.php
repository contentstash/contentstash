<?php

use ContentStash\Core\Http\Controllers\DashboardController;
use ContentStash\Core\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'as' => 'dashboard.',
        'prefix' => 'dashboard',
    ],
    function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');

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
