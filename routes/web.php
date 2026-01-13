<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

// Route for a new page
Route::get('/colors', function () {
    return view('colors');
});

Route::get('/input-sbp', function () {
    return view('input-sbp');
});

// Fallback route for 404 pages
Route::fallback(function () {
    return view('dashboard');
});
