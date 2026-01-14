<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SbpController;
use App\Http\Controllers\PetugasController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/colors', function () {
    return view('colors');
});

Route::get('/input-sbp', [SbpController::class, 'create'])->name('sbp.create');
Route::post('/input-sbp', [SbpController::class, 'store'])->name('sbp.store');

// Routes for Data SBP (CRUD)
Route::get('/data-sbp', [SbpController::class, 'index'])->name('sbp.index');
// Route::get('/data-sbp/{sbp}/edit', [SbpController::class, 'edit'])->name('sbp.edit'); // No longer needed
Route::put('/data-sbp/{sbp}', [SbpController::class, 'update'])->name('sbp.update');
Route::delete('/data-sbp/{sbp}', [SbpController::class, 'destroy'])->name('sbp.destroy');

// Routes for Data Petugas (CRUD)
Route::resource('petugas', PetugasController::class);
