<?php

use ContentStash\Core\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'as' => 'dashboard.',
        'prefix' => 'dashboard',
    ], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });
