<?php

namespace App\Http\Controllers;

use App\Models\Sbp;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        $validatedData = $request->validate([
            'nomor_sbp' => 'required|integer',
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

        $year = Carbon::parse($validatedData['tanggal_sbp'])->year;
        $formattedSbp = "SBP-{$validatedData['nomor_sbp']}/KBC.0102/{$year}";

        // Validate uniqueness on the formatted string
        $request->merge(['nomor_sbp_formatted' => $formattedSbp]);
        $request->validate([
            'nomor_sbp_formatted' => 'unique:sbp,nomor_sbp'
        ], [
            'nomor_sbp_formatted.unique' => 'Kombinasi Nomor SBP dan Tahun sudah ada.'
        ]);

        // Replace the integer with the formatted string for storage
        $validatedData['nomor_sbp'] = $formattedSbp;

        Sbp::create($validatedData);
        return redirect()->route('sbp.create')->with('success', "Data SBP dengan nomor {$formattedSbp} berhasil disimpan.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sbp $sbp)
    {
        // Extract the integer part from the formatted string for the form
        preg_match('/^SBP-(\d+)\/KBC\.0102\/\d{4}$/', $sbp->nomor_sbp, $matches);
        $sbp->nomor_sbp_int = $matches[1] ?? '';

        $petugasData = Petugas::orderBy('nama', 'asc')->get();
        return view('edit-sbp', compact('sbp', 'petugasData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sbp $sbp)
    {
        $validatedData = $request->validate([
            'nomor_sbp' => 'required|integer',
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
        
        $year = Carbon::parse($validatedData['tanggal_sbp'])->year;
        $formattedSbp = "SBP-{$validatedData['nomor_sbp']}/KBC.0102/{$year}";

        // Validate uniqueness on the formatted string, ignoring the current SBP's ID
        $request->merge(['nomor_sbp_formatted' => $formattedSbp]);
        $request->validate([
            'nomor_sbp_formatted' => 'unique:sbp,nomor_sbp,' . $sbp->id
        ], [
            'nomor_sbp_formatted.unique' => 'Kombinasi Nomor SBP dan Tahun sudah ada.'
        ]);
        
        // Replace the integer with the formatted string for storage
        $validatedData['nomor_sbp'] = $formattedSbp;

        $sbp->update($validatedData);
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
