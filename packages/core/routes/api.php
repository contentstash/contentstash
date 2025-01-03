<?php

use ContentStash\Core\Http\Controllers\Api\ModelController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'as' => 'api.',
        'prefix' => 'api',
        'middleware' => ['web'],
    ],
    function () {
        Route::group(
            [
                'as' => 'slug.',
                'prefix' => '{slug}',
            ],
            function () {
                Route::get('/', [ModelController::class, 'index'])->name('index');
                Route::post('/', [ModelController::class, 'store'])->name('store');
                Route::get('/{resource}', [ModelController::class, 'show'])->name('show');
                Route::put('/{resource}', [ModelController::class, 'update'])->name('update');
                Route::delete('/{resource}', [ModelController::class, 'destroy'])->name('destroy');
            }
        );
    }
);
