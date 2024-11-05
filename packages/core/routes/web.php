<?php

use ContentStash\Core\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'as' => 'dashboard.',
        'prefix' => 'dashboard',
    ], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/2', [DashboardController::class, 'index2'])->name('index2');
    });
