<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SbpController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\DatabaseController;

// Route utama ke Dashboard
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
});

// Route untuk SBP
Route::get('/input-sbp', [SbpController::class, 'create'])->name('sbp.create');
Route::post('/input-sbp', [SbpController::class, 'store'])->name('sbp.store');
Route::get('/data-sbp', [SbpController::class, 'index'])->name('sbp.index');
Route::put('/data-sbp/{sbp}', [SbpController::class, 'update'])->name('sbp.update');
Route::delete('/data-sbp/{sbp}', [SbpController::class, 'destroy'])->name('sbp.destroy');

// Route untuk Petugas
Route::get('/input-petugas', [PetugasController::class, 'create'])->name('petugas.create');
Route::post('/input-petugas', [PetugasController::class, 'store'])->name('petugas.store');
Route::get('/data-petugas', [PetugasController::class, 'index'])->name('petugas.index');
Route::put('/data-petugas/{petugas}', [PetugasController::class, 'update'])->name('petugas.update');
Route::delete('/data-petugas/{petugas}', [PetugasController::class, 'destroy'])->name('petugas.destroy');

// Route untuk Database Explorer
Route::get('/database', [DatabaseController::class, 'index'])->name('database.index');
Route::get('/database/{table}', [DatabaseController::class, 'showTable'])->name('database.table');
