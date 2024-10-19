<?php
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('cms', function() {
    return 'Welcome to your CMS!2';
});

Route::get('test', function() {
    return Inertia::render('Test');
});

Route::get('cp', function() {
    return Inertia::render('Cp');
});