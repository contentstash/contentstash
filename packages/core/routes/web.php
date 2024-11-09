<?php

use ContentStash\Core\Http\Controllers\DashboardController;
use ContentStash\Core\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'as' => 'dashboard.',
        'prefix' => 'dashboard',
    ], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/2', [DashboardController::class, 'index2'])->name('index2');
    });

Route::get('/translations/{locale}', [LanguageController::class, 'getTranslations']);
Route::get('/routes/', [\ContentStash\Core\Http\Controllers\RoutesController::class, 'index']);
