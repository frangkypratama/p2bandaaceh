<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sbp;
use App\Models\Petugas;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Define Cukai-related items
        $cukaiItems = ['Hasil Tembakau', 'MMEA', 'Etil Alkohol'];

        // Widget Counts
        $sbpCount = Sbp::count();
        $petugasCount = Petugas::count();
        $cukaiCount = Sbp::whereIn('jenis_barang', $cukaiItems)->count();
        $kepabeananCount = Sbp::whereNotIn('jenis_barang', $cukaiItems)->count();

        // Pie Chart: Jenis Barang
        $jenisBarangResult = Sbp::select('jenis_barang', DB::raw('count(*) as total'))
            ->whereNotNull('jenis_barang')
            ->groupBy('jenis_barang')
            ->get();
        $jenisBarangLabels = $jenisBarangResult->pluck('jenis_barang');
        $jenisBarangCounts = $jenisBarangResult->pluck('total');

        // Bar Chart: Top 5 Kota
        $kotaResult = Sbp::select('kota_penindakan', DB::raw('count(*) as total'))
            ->whereNotNull('kota_penindakan')
            ->groupBy('kota_penindakan')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        $kotaLabels = $kotaResult->pluck('kota_penindakan');
        $kotaCounts = $kotaResult->pluck('total');

        // Bar Chart: Top 5 Kecamatan
        $kecamatanResult = Sbp::select('kecamatan_penindakan', DB::raw('count(*) as total'))
            ->whereNotNull('kecamatan_penindakan')
            ->groupBy('kecamatan_penindakan')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        $kecamatanLabels = $kecamatanResult->pluck('kecamatan_penindakan');
        $kecamatanCounts = $kecamatanResult->pluck('total');

        return view('dashboard', compact(
            'sbpCount',
            'petugasCount',
            'kepabeananCount',
            'cukaiCount',
            'jenisBarangLabels',
            'jenisBarangCounts',
            'kotaLabels',
            'kotaCounts',
            'kecamatanLabels',
            'kecamatanCounts'
        ));
    }
}
