<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SbpController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\PangkatGolonganController;
use App\Http\Controllers\BastController;
use App\Http\Controllers\RefPelanggaranController;
use App\Http\Controllers\RefSatuanController;
use App\Http\Controllers\SuratPerintahController;
use App\Http\Controllers\BariksaBadanController;
use App\Http\Controllers\PemeriksaanBadanController;
use App\Http\Controllers\LptController;
use App\Http\Controllers\LphpController;
use App\Http\Controllers\LpController;
use App\Http\Controllers\LppController;
use App\Http\Controllers\SplitController;
use App\Http\Controllers\LpfController;
use App\Http\Controllers\LhpController;
use App\Http\Controllers\PencacahanController;
use App\Http\Controllers\RefJenisBarangController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RefTarifCukaiController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Autentikasi
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {

/*
|--------------------------------------------------------------------------
| Dashboard & utilitas umum (semua user login boleh akses)
|--------------------------------------------------------------------------
*/
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/lokasi/kecamatan', [LokasiController::class, 'getKecamatan'])->name('lokasi.kecamatan');
Route::get('/api/sbp/{id}', [SbpController::class, 'showApi'])->name('sbp.api.show');

/*
|--------------------------------------------------------------------------
| SBP
|--------------------------------------------------------------------------
*/
Route::middleware('permission:sbp')->group(function () {
    // Get Last SBP Number
    Route::get('/sbp/get-last-number', [SbpController::class, 'getLastNumber'])->name('sbp.get-last-number');

    // Excel Export
    Route::get('/data-sbp/export/excel', [SbpController::class, 'exportExcel'])->name('sbp.export.excel');

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

    Route::get('/data-sbp/pdf-label/{id}', [SbpController::class, 'generatePdfLabel'])
        ->name('sbp.pdf.label');

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
});

/*
|--------------------------------------------------------------------------
| Petugas
|--------------------------------------------------------------------------
*/
Route::middleware('permission:petugas')->group(function () {
    Route::get('/data-petugas', [PetugasController::class, 'index'])->name('petugas.index');
    Route::post('/data-petugas', [PetugasController::class, 'store'])->name('petugas.store');
    Route::put('/data-petugas/{petugas}', [PetugasController::class, 'update'])->name('petugas.update');
    Route::delete('/data-petugas/{petugas}', [PetugasController::class, 'destroy'])->name('petugas.destroy');
});

/*
|--------------------------------------------------------------------------
| BAST
|--------------------------------------------------------------------------
*/
Route::middleware('permission:bast')->group(function () {
    Route::resource('bast', BastController::class);
});

/*
|--------------------------------------------------------------------------
| Referensi Pelanggaran
|--------------------------------------------------------------------------
*/
Route::middleware('permission:ref-pelanggaran')->group(function () {
    Route::resource('ref-pelanggaran', RefPelanggaranController::class);
});

/*
|--------------------------------------------------------------------------
| Referensi Satuan
|--------------------------------------------------------------------------
*/
Route::middleware('permission:ref-satuan')->group(function () {
    Route::resource('ref-satuan', RefSatuanController::class);
});

/*
|--------------------------------------------------------------------------
| Referensi Jenis Barang
|--------------------------------------------------------------------------
*/
Route::middleware('permission:ref-jenis-barang')->group(function () {
    Route::resource('ref-jenis-barang', RefJenisBarangController::class);
});

/*
|--------------------------------------------------------------------------
| Referensi Tarif Cukai
|--------------------------------------------------------------------------
*/
Route::middleware('permission:ref-tarif-cukai')->group(function () {
    Route::resource('ref-tarif-cukai', RefTarifCukaiController::class);
});

/*
|--------------------------------------------------------------------------
| Surat Perintah
|--------------------------------------------------------------------------
*/
Route::middleware('permission:surat-perintah')->group(function () {
    Route::resource('surat-perintah', SuratPerintahController::class)->except(['create', 'edit', 'show']);
});

/*
|--------------------------------------------------------------------------
| Bariksa Badan
|--------------------------------------------------------------------------
*/
Route::middleware('permission:bariksa-badan')->group(function () {
    Route::resource('bariksa-badan', BariksaBadanController::class);
});

/*
|--------------------------------------------------------------------------
| Pemeriksaan Badan
|--------------------------------------------------------------------------
*/
Route::middleware('permission:pemeriksaan-badan')->group(function () {
    // Rute untuk Cetak PDF (harus di atas resource)
    Route::get('pemeriksaan-badan/{id}/cetak', [PemeriksaanBadanController::class, 'cetak'])->name('pemeriksaan-badan.cetak');
    Route::get('/pemeriksaan-badan/get-last-number', [PemeriksaanBadanController::class, 'getLastNumber'])->name('pemeriksaan-badan.get-last-number');

    // Rute Resource
    Route::resource('pemeriksaan-badan', PemeriksaanBadanController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| LPT
|--------------------------------------------------------------------------
*/
Route::middleware('permission:lpt')->group(function () {
    Route::get('/lpt/photos/{photo}', [LptController::class, 'showPhoto'])->name('lpt.showPhoto');
    Route::resource('lpt', LptController::class)->except(['show']);
    Route::get('/lpt/{id}/preview', [LptController::class, 'preview'])->name('lpt.preview');
    Route::get('/lpt/{id}/laporan-wa', [LptController::class, 'laporanWa'])->name('lpt.laporan-wa');
});

/*
|--------------------------------------------------------------------------
| LPHP (Lembar Penentuan Hasil Penindakan)
|--------------------------------------------------------------------------
*/
Route::middleware('permission:lphp')->group(function () {
    Route::get('/lphp/{id}/preview', [LphpController::class, 'preview'])->name('lphp.preview');
    Route::get('/lphp/pilih-sbp', [LphpController::class, 'pickSbp'])->name('lphp.pilih-sbp');
    Route::resource('lphp', LphpController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| LP (Laporan Pelanggaran)
|--------------------------------------------------------------------------
*/
Route::middleware('permission:lp')->group(function () {
    Route::get('/lp/{id}/preview', [LpController::class, 'preview'])->name('lp.preview');
    Route::get('/lp/pilih-lphp', [LpController::class, 'pickLphp'])->name('lp.pilih-lphp');
    Route::resource('lp', LpController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| LPP (Lembar Penerimaan Perkara)
|--------------------------------------------------------------------------
*/
Route::middleware('permission:lpp')->group(function () {
    Route::get('/lpp/{id}/preview', [LppController::class, 'preview'])->name('lpp.preview');
    Route::get('/lpp/pilih-lp', [LppController::class, 'pickLp'])->name('lpp.pilih-lp');
    Route::resource('lpp', LppController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| SPLIT (Surat Perintah Penelitian)
|--------------------------------------------------------------------------
*/
Route::middleware('permission:split')->group(function () {
    Route::get('/split/{id}/preview', [SplitController::class, 'preview'])->name('split.preview');
    Route::get('/split/pilih-lpf', [SplitController::class, 'pickLpf'])->name('split.pilih-lpf');
    Route::resource('split', SplitController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| LPF (Lembar Penelitian Formal)
|--------------------------------------------------------------------------
*/
Route::middleware('permission:lpf')->group(function () {
    Route::get('/lpf/{id}/preview', [LpfController::class, 'preview'])->name('lpf.preview');
    Route::get('/lpf/pilih-lpp', [LpfController::class, 'pickLpp'])->name('lpf.pilih-lpp');
    Route::resource('lpf', LpfController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| LHP (Lembar Hasil Penelitian)
|--------------------------------------------------------------------------
*/
Route::middleware('permission:lhp')->group(function () {
    Route::get('/lhp/{id}/preview', [LhpController::class, 'preview'])->name('lhp.preview');
    Route::get('/lhp/{id}/preview-berkas', [LhpController::class, 'previewBerkas'])->name('lhp.preview-berkas');
    Route::get('/lhp/pilih-split', [LhpController::class, 'pickSplit'])->name('lhp.pilih-split');
    Route::resource('lhp', LhpController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| Pencacahan
|--------------------------------------------------------------------------
*/
Route::middleware('permission:pencacahan')->group(function () {
    Route::get('/pencacahan/photos/{photo}', [PencacahanController::class, 'showPhoto'])->name('pencacahan.showPhoto');
    Route::get('/pencacahan/search-sbp', [PencacahanController::class, 'searchSbp'])->name('pencacahan.searchSbp');
    Route::post('/pencacahan/get-barang-fields', [PencacahanController::class, 'getBarangFields'])->name('pencacahan.getBarangFields');
    Route::get('/pencacahan/{id}/cetak', [PencacahanController::class, 'cetak'])->name('pencacahan.cetak');
    Route::resource('pencacahan', PencacahanController::class);
});

/*
|--------------------------------------------------------------------------
| Database Explorer
|--------------------------------------------------------------------------
*/
Route::middleware('permission:database')->group(function () {
    Route::get('/database', [DatabaseController::class, 'database'])->name('database.database');
    Route::get('/database/{table}', [DatabaseController::class, 'showTable'])->name('database.table');
});

/*
|--------------------------------------------------------------------------
| Log Aktivitas, User Management & Role Management (khusus admin)
|--------------------------------------------------------------------------
| Sengaja TIDAK ikut matrix permission biasa (permission:xxx) supaya tidak
| bisa terjadi eskalasi hak akses lewat role custom — hanya role is_admin
| yang boleh mengelola user, role, dan melihat log aktivitas.
*/
Route::middleware('admin')->group(function () {
    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');

    Route::get('/data-user', [UserController::class, 'index'])->name('user-management.index');
    Route::post('/data-user', [UserController::class, 'store'])->name('user-management.store');
    Route::put('/data-user/{user}', [UserController::class, 'update'])->name('user-management.update');
    Route::put('/data-user/{user}/reset-password', [UserController::class, 'resetPassword'])->name('user-management.reset-password');
    Route::delete('/data-user/{user}', [UserController::class, 'destroy'])->name('user-management.destroy');

    Route::get('/data-role', [RoleController::class, 'index'])->name('role-management.index');
    Route::post('/data-role', [RoleController::class, 'store'])->name('role-management.store');
    Route::put('/data-role/{role}', [RoleController::class, 'update'])->name('role-management.update');
    Route::delete('/data-role/{role}', [RoleController::class, 'destroy'])->name('role-management.destroy');
});

/*
|--------------------------------------------------------------------------
| Profil Saya (user management pribadi milik sendiri)
|--------------------------------------------------------------------------
*/
Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

}); // end Route::middleware('auth')
