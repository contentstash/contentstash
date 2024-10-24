<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('cms', function () {
    return 'Welcome to your CMS!2';
});

Route::get('test', function () {
    return Inertia::render('Test');
});

Route::get('cp', function () {
    return Inertia::render('Cp');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        return Inertia::render('Admin/Index');
    });
});
