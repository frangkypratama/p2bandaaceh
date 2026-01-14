<?php

namespace App\Http\Controllers;

use App\Models\Sbp;
use App\Models\Petugas;
use Illuminate\Http\Request;

class SbpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sbpData = Sbp::orderBy('tanggal_sbp', 'desc')->paginate(10);
        return view('data-sbp', compact('sbpData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $petugasData = Petugas::orderBy('nama', 'asc')->get();
        return view('input-sbp', compact('petugasData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_sbp' => 'required|unique:sbp|max:255',
            'tanggal_sbp' => 'required|date',
            // ... (validasi lainnya)
        ]);

        Sbp::create($request->all());
        return redirect()->route('sbp.create')->with('success', 'Data SBP berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sbp $sbp)
    {
        $petugasData = Petugas::orderBy('nama', 'asc')->get();
        return view('edit-sbp', compact('sbp', 'petugasData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sbp $sbp)
    {
        $request->validate([
            'nomor_sbp' => 'required|max:255|unique:sbp,nomor_sbp,' . $sbp->id,
            'tanggal_sbp' => 'required|date',
            'nomor_surat_perintah' => 'required|string|max:255',
            'tanggal_surat_perintah' => 'required|date',
            'nama_pelaku' => 'required|string|max:255',
            'jenis_identitas' => 'required|string|max:255',
            'nomor_identitas' => 'required|string|max:255',
            'lokasi_penindakan' => 'required|string|max:255',
            'waktu_penindakan' => 'required',
            'alasan_penindakan' => 'required|string',
            'jenis_barang' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer',
            'jenis_satuan' => 'required|string|max:255',
            'uraian_barang' => 'required|string',
            'nama_petugas_1' => 'required|string|max:255',
            'nama_petugas_2' => 'required|string|max:255',
        ]);

        $sbp->update($request->all());
        return redirect()->route('sbp.index')->with('success', 'Data SBP berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sbp $sbp)
    {
        $sbp->delete();
        return redirect()->route('sbp.index')->with('success', 'Data SBP berhasil dihapus.');
    }
}
