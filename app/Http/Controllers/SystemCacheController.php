<?php

namespace App\Http\Controllers;

use App\Models\PangkatGolongan;
use App\Models\RefJenisBarang;
use App\Models\RefPelanggaran;
use App\Models\RefSatuan;
use App\Models\RefTarifCukai;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;

class SystemCacheController extends Controller
{
    /**
     * Model referensi yang di-cache lewat trait Cacheable.
     */
    protected const CACHED_MODELS = [
        'Referensi Satuan' => RefSatuan::class,
        'Referensi Jenis Barang' => RefJenisBarang::class,
        'Referensi Tarif Cukai' => RefTarifCukai::class,
        'Referensi Pelanggaran' => RefPelanggaran::class,
        'Pangkat / Golongan' => PangkatGolongan::class,
    ];

    public function index()
    {
        $cacheDriver = config('cache.default');

        $cachedItems = collect(self::CACHED_MODELS)->map(function (string $model, string $label) {
            return [
                'label' => $label,
                'jumlah' => $model::cached()->count(),
            ];
        });

        $rolesCount = Role::count();

        return view('system-cache.index', compact('cacheDriver', 'cachedItems', 'rolesCount'));
    }

    public function clear(): RedirectResponse
    {
        Artisan::call('cache:clear');

        return redirect()->route('system-cache.index')->with('success', 'Cache berhasil dibersihkan.');
    }
}
