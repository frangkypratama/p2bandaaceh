<?php

namespace App\Http\Controllers;

use App\Models\Sbp;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $validated = $request->validate([
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

        $year = Carbon::parse($validated['tanggal_sbp'])->year;
        $nomor = $validated['nomor_sbp'];

        // ===== FORMAT NOMOR =====
        $formattedSbp = "SBP-{$nomor}/KBC.0102/{$year}";
        $formattedBaRiksa = "BA-{$nomor}/RIKSA/KBC.010202/{$year}";
        $formattedBaTegah = "BA-{$nomor}/TEGAH/KBC.010202/{$year}";
        $formattedBaSegel = "BA-{$nomor}/SEGEL/KBC.010202/{$year}";

        // ===== VALIDASI UNIK (STRING FINAL) =====
        $request->merge(['nomor_sbp_final' => $formattedSbp]);
        $request->validate([
            'nomor_sbp_final' => 'unique:sbp,nomor_sbp'
        ], [
            'nomor_sbp_final.unique' => 'Nomor SBP dengan tahun tersebut sudah ada.'
        ]);

        // ===== SIMPAN =====
        $validated['nomor_sbp'] = $formattedSbp;
        $validated['nomor_ba_riksa'] = $formattedBaRiksa;
        $validated['nomor_ba_tegah'] = $formattedBaTegah;
        $validated['nomor_ba_segel'] = $formattedBaSegel;

        Sbp::create($validated);

        return redirect()
            ->route('sbp.create')
            ->with('success', "SBP {$formattedSbp} berhasil disimpan.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sbp $sbp)
    {
        // Ambil angka dari "SBP-12/KBC.0102/2025"
        preg_match('/SBP-(\d+)\//', $sbp->nomor_sbp, $match);
        $sbp->nomor_sbp_int = $match[1] ?? '';

        $petugasData = Petugas::orderBy('nama', 'asc')->get();
        return view('edit-sbp', compact('sbp', 'petugasData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sbp $sbp)
    {
        $validated = $request->validate([
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

        $year = Carbon::parse($validated['tanggal_sbp'])->year;
        $nomor = $validated['nomor_sbp'];

        $formattedSbp = "SBP-{$nomor}/KBC.0102/{$year}";
        $formattedBaRiksa = "BA-{$nomor}/RIKSA/KBC.010202/{$year}";
        $formattedBaTegah = "BA-{$nomor}/TEGAH/KBC.010202/{$year}";
        $formattedBaSegel = "BA-{$nomor}/SEGEL/KBC.010202/{$year}";

        $request->merge(['nomor_sbp_final' => $formattedSbp]);
        $request->validate([
            'nomor_sbp_final' => 'unique:sbp,nomor_sbp,' . $sbp->id
        ]);

        $validated['nomor_sbp'] = $formattedSbp;
        $validated['nomor_ba_riksa'] = $formattedBaRiksa;
        $validated['nomor_ba_tegah'] = $formattedBaTegah;
        $validated['nomor_ba_segel'] = $formattedBaSegel;

        $sbp->update($validated);

        return redirect()
            ->route('sbp.index')
            ->with('success', 'Data SBP berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sbp $sbp)
    {
        $sbp->delete();
        return redirect()->route('sbp.index')->with('success', 'Data SBP berhasil dihapus.');
    }

    /**
     * Preview cetak SBP (iframe).
     */
    public function cetakPreview($id)
    {
        $sbp = Sbp::findOrFail($id);
        return view('preview-sbp', compact('sbp'));
    }

    /**
     * Generate PDF SBP (F4 FIX).
     */
    public function generatePdf($id)
    {
        $sbp = Sbp::findOrFail($id);

        $pdf = Pdf::loadView('templatecetak.templatesbp', compact('sbp'))
            // ===== F4 REAL SIZE (pt) =====
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $sbp->nomor_sbp) . '.pdf';

        return $pdf->stream($filename);
    }
}
