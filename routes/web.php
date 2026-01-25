<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SbpController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\PangkatGolonganController;
use App\Http\Controllers\BastController;
use App\Http\Controllers\RefPelanggaranController;

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('dashboard'))->name('dashboard');
Route::get('/dashboard', fn () => view('dashboard'));

/*
|--------------------------------------------------------------------------
| SBP
|--------------------------------------------------------------------------
*/

// Preview & PDF (HARUS DI ATAS)
Route::get('/data-sbp/cetak-preview/{id}', [SbpController::class, 'cetakPreview'])
    ->name('sbp.cetak.preview');

Route::get('/data-sbp/pdf/{id}', [SbpController::class, 'generatePdf'])
    ->name('sbp.pdf');

Route::get('/data-sbp/pdf-ba-riksa/{id}', [SbpController::class, 'generatePdfBaRiksa'])
    ->name('sbp.pdf.ba-riksa');

Route::get('/data-sbp/pdf-ba-tegah/{id}', [SbpController::class, 'generatePdfBaTegah'])
    ->name('sbp.pdf.ba-tegah');

Route::get('/data-sbp/pdf-ba-segel/{id}', [SbpController::class, 'generatePdfBaSegel'])
    ->name('sbp.pdf.ba-segel');

Route::get('/data-sbp/pdf-bast/{id}', [SbpController::class, 'generatePdfBast'])
    ->name('sbp.pdf.bast');

Route::get('/data-sbp/pdf-semua/{id}', [SbpController::class, 'generatePdfSemua'])
    ->name('sbp.pdf.semua');

Route::get('/data-sbp/pdf-checklist/{id}', [SbpController::class, 'generatePdfChecklist'])
    ->name('sbp.pdf.checklist');

Route::get('/sbp/{sbp}/pdf/ba-musnah', [SbpController::class, 'cetakBaMusnah'])
    ->name('sbp.cetak.ba-musnah');

// CRUD SBP
Route::get('/input-sbp', [SbpController::class, 'create'])->name('sbp.create');
Route::post('/input-sbp', [SbpController::class, 'store'])->name('sbp.store');
Route::get('/data-sbp', [SbpController::class, 'index'])->name('sbp.index');

Route::get('/data-sbp/{sbp}/edit', [SbpController::class, 'edit'])
    ->name('sbp.edit');

Route::put('/data-sbp/{sbp}', [SbpController::class, 'update'])
    ->name('sbp.update');

Route::delete('/data-sbp/{sbp}', [SbpController::class, 'destroy'])
    ->name('sbp.destroy');

/*
|--------------------------------------------------------------------------
| Petugas
|--------------------------------------------------------------------------
*/
Route::get('/data-petugas', [PetugasController::class, 'index'])->name('petugas.index');
Route::post('/data-petugas', [PetugasController::class, 'store'])->name('petugas.store');
Route::put('/data-petugas/{petugas}', [PetugasController::class, 'update'])->name('petugas.update');
Route::delete('/data-petugas/{petugas}', [PetugasController::class, 'destroy'])->name('petugas.destroy');

/*
|--------------------------------------------------------------------------
| BAST
|--------------------------------------------------------------------------
*/
Route::resource('bast', BastController::class);

/*
|--------------------------------------------------------------------------
| Referensi Pelanggaran
|--------------------------------------------------------------------------
*/
Route::resource('ref-pelanggaran', RefPelanggaranController::class);


/*
|--------------------------------------------------------------------------
| Database Explorer
|--------------------------------------------------------------------------
*/
Route::get('/database', [DatabaseController::class, 'database'])->name('database.database');
Route::get('/database/{table}', [DatabaseController::class, 'showTable'])->name('database.table');
