<?php

namespace App\Http\Controllers;

use App\Models\Sbp;
use App\Models\Petugas;
use App\Models\Bast;
use App\Models\RefPelanggaran;
use App\Models\RefSatuan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class SbpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sbpData = Sbp::with(['petugas1', 'petugas2', 'bast'])->orderBy('tanggal_sbp', 'desc')
                        ->orderBy('nomor_sbp_int', 'desc')
                        ->paginate(10);
        return view('data-sbp', compact('sbpData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $petugasData = Petugas::orderBy('nama', 'asc')->get();
        $refPelanggaranData = RefPelanggaran::all();
        $refSatuanData = RefSatuan::orderBy('nama_satuan', 'asc')->get();
        return view('input-sbp', compact('petugasData', 'refPelanggaranData', 'refSatuanData'));
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
            'jenis_satuan' => 'required|string|exists:ref_satuan,nama_satuan',
            'uraian_barang' => 'required|string',
            'id_petugas_1' => 'required|integer|exists:petugas,id',
            'id_petugas_2' => 'required|integer|exists:petugas,id|different:id_petugas_1',
            'kota' => 'required|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'flag_bast' => 'nullable|boolean',
            'flag_ba_musnah' => 'nullable|boolean',
            'nomor_ba_musnah' => 'nullable|string|max:255',
        ]);

        if ($request->boolean('flag_bast')) {
            $request->validate([
                'nomor_bast' => 'required|string|max:255|unique:bast,nomor_bast',
                'tanggal_bast' => 'required|date',
                'jenis_dokumen' => 'nullable|string|max:255',
                'tanggal_dokumen' => 'nullable|date',
                'petugas_eksternal' => 'required|string|max:255',
                'nip_nrp_petugas_eksternal' => 'required|string|max:255',
                'instansi_eksternal' => 'required|string|max:255',
                'dalam_rangka' => 'required|string',
            ]);
        }

        $nomor_sbp_int = $validated['nomor_sbp'];
        $tahun_sbp = Carbon::parse($validated['tanggal_sbp'])->year;

        // ===== FORMAT NOMOR =====
        $formattedSbp = "SBP-{$nomor_sbp_int}/KBC.0102/{$tahun_sbp}";
        $formattedBaRiksa = "BA-{$nomor_sbp_int}/RIKSA/KBC.010202/{$tahun_sbp}";
        $formattedBaTegah = "BA-{$nomor_sbp_int}/TEGAH/KBC.010202/{$tahun_sbp}";
        $formattedBaSegel = "BA-{$nomor_sbp_int}/SEGEL/KBC.010202/{$tahun_sbp}";

        // ===== VALIDASI UNIK (STRING FINAL) =====
        $request->merge(['nomor_sbp_final' => $formattedSbp]);
        $request->validate([
            'nomor_sbp_final' => Rule::unique('sbp', 'nomor_sbp')->whereNull('deleted_at')
        ], [
            'nomor_sbp_final.unique' => 'Nomor SBP dengan tahun tersebut sudah ada.'
        ]);
        
        DB::transaction(function () use ($validated, $request, $nomor_sbp_int, $tahun_sbp, $formattedSbp, $formattedBaRiksa, $formattedBaTegah, $formattedBaSegel) {
            // ===== AMBIL NAMA PETUGAS =====
            $petugas1 = Petugas::find($validated['id_petugas_1']);
            $petugas2 = Petugas::find($validated['id_petugas_2']);

            // ===== SIMPAN SBP =====
            $dataToStore = $validated;
            $dataToStore['kota_penindakan'] = $validated['kota'];
            $dataToStore['kecamatan_penindakan'] = $validated['kecamatan'];
            $dataToStore['nama_petugas_1'] = $petugas1->nama;
            $dataToStore['nama_petugas_2'] = $petugas2->nama;
            $dataToStore['nomor_sbp'] = $formattedSbp;
            $dataToStore['nomor_ba_riksa'] = $formattedBaRiksa;
            $dataToStore['nomor_ba_tegah'] = $formattedBaTegah;
            $dataToStore['nomor_ba_segel'] = $formattedBaSegel;
            $dataToStore['nomor_sbp_int'] = $nomor_sbp_int;
            $dataToStore['flag_bast'] = $request->boolean('flag_bast');
            $dataToStore['flag_ba_musnah'] = $request->boolean('flag_ba_musnah');
            $dataToStore['nomor_ba_musnah'] = $request->boolean('flag_ba_musnah') ? $validated['nomor_ba_musnah'] : null;

            $sbp = Sbp::create($dataToStore);

            // ===== SIMPAN BAST JIKA ADA =====
            if ($request->boolean('flag_bast')) {
                $bastData = $request->only([
                    'nomor_bast',
                    'tanggal_bast',
                    'jenis_dokumen',
                    'tanggal_dokumen',
                    'petugas_eksternal',
                    'nip_nrp_petugas_eksternal',
                    'instansi_eksternal',
                    'dalam_rangka',
                ]);
                $sbp->bast()->create($bastData);
            }
        });

        return redirect()
            ->route('sbp.index')
            ->with('success', "{$formattedSbp} berhasil disimpan.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sbp $sbp)
    {
        // Ambil angka dari "SBP-12/KBC.0102/2025"
        preg_match('/SBP-(\d+)\//', $sbp->nomor_sbp, $match);
        $sbp->nomor_sbp_int = $match[1] ?? '';
        
        $sbp->load('bast');

        $petugasData = Petugas::orderBy('nama', 'asc')->get();
        $refPelanggaranData = RefPelanggaran::all();
        $refSatuanData = RefSatuan::orderBy('nama_satuan', 'asc')->get();

        return view('edit-sbp', compact('sbp', 'petugasData', 'refPelanggaranData', 'refSatuanData'));
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
            'jenis_satuan' => 'required|string|exists:ref_satuan,nama_satuan',
            'uraian_barang' => 'required|string',
            'id_petugas_1' => 'required|integer|exists:petugas,id',
            'id_petugas_2' => 'required|integer|exists:petugas,id|different:id_petugas_1',
            'kota' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'flag_bast' => 'nullable|boolean',
            'flag_ba_musnah' => 'nullable|boolean',
            'nomor_ba_musnah' => 'nullable|string|max:255',
            'delete_bast' => 'nullable|boolean',
        ]);

        if ($request->boolean('flag_bast')) {
            $request->validate([
                'nomor_bast' => 'required|string|max:255|unique:bast,nomor_bast,' . ($sbp->bast->id ?? 'NULL') . ',id',
                'tanggal_bast' => 'required|date',
                'jenis_dokumen' => 'nullable|string|max:255',
                'tanggal_dokumen' => 'nullable|date',
                'petugas_eksternal' => 'required|string|max:255',
                'nip_nrp_petugas_eksternal' => 'required|string|max:255',
                'instansi_eksternal' => 'required|string|max:255',
                'dalam_rangka' => 'required|string',
            ]);
        }

        $nomor_sbp_int = $validated['nomor_sbp'];
        $tahun_sbp = Carbon::parse($validated['tanggal_sbp'])->year;

        $formattedSbp = "SBP-{$nomor_sbp_int}/KBC.0102/{$tahun_sbp}";
        $formattedBaRiksa = "BA-{$nomor_sbp_int}/RIKSA/KBC.010202/{$tahun_sbp}";
        $formattedBaTegah = "BA-{$nomor_sbp_int}/TEGAH/KBC.010202/{$tahun_sbp}";
        $formattedBaSegel = "BA-{$nomor_sbp_int}/SEGEL/KBC.010202/{$tahun_sbp}";

        $request->merge(['nomor_sbp_final' => $formattedSbp]);
        $request->validate([
            'nomor_sbp_final' => Rule::unique('sbp', 'nomor_sbp')->whereNull('deleted_at')->ignore($sbp->id)
        ], [
            'nomor_sbp_final.unique' => 'Nomor SBP dengan tahun tersebut sudah ada.'
        ]);

        DB::transaction(function () use ($sbp, $validated, $request, $nomor_sbp_int, $tahun_sbp, $formattedSbp, $formattedBaRiksa, $formattedBaTegah, $formattedBaSegel) {
            $petugas1 = Petugas::find($validated['id_petugas_1']);
            $petugas2 = Petugas::find($validated['id_petugas_2']);

            $dataToUpdate = $validated;
            $dataToUpdate['kota_penindakan'] = $validated['kota'];
            $dataToUpdate['kecamatan_penindakan'] = $validated['kecamatan'];
            $dataToUpdate['nama_petugas_1'] = $petugas1->nama;
            $dataToUpdate['nama_petugas_2'] = $petugas2->nama;
            $dataToUpdate['nomor_sbp'] = $formattedSbp;
            $dataToUpdate['nomor_ba_riksa'] = $formattedBaRiksa;
            $dataToUpdate['nomor_ba_tegah'] = $formattedBaTegah;
            $dataToUpdate['nomor_ba_segel'] = $formattedBaSegel;
            $dataToUpdate['nomor_sbp_int'] = $nomor_sbp_int;
            $dataToUpdate['flag_bast'] = $request->boolean('flag_bast');
            $dataToUpdate['flag_ba_musnah'] = $request->boolean('flag_ba_musnah');
            $dataToUpdate['nomor_ba_musnah'] = $request->boolean('flag_ba_musnah') ? $validated['nomor_ba_musnah'] : null;

            $sbp->update($dataToUpdate);

            if ($request->boolean('delete_bast') && $sbp->bast) {
                $sbp->bast->delete();
            } elseif ($request->boolean('flag_bast')) {
                $bastData = $request->only([
                    'nomor_bast',
                    'tanggal_bast',
                    'jenis_dokumen',
                    'tanggal_dokumen',
                    'petugas_eksternal',
                    'nip_nrp_petugas_eksternal',
                    'instansi_eksternal',
                    'dalam_rangka',
                ]);
                $sbp->bast()->updateOrCreate(['sbp_id' => $sbp->id], $bastData);
            }
        });

        return redirect()->route('sbp.index')->with('success', 'Data SBP berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */

     public function destroy(Sbp $sbp)
     {
         // Menggunakan transaksi untuk memastikan integritas data
         DB::transaction(function () use ($sbp) {
             // Memuat relasi BAST secara eksplisit
             $sbp->load('bast');
             
             // Jika ada BAST terkait, hapus terlebih dahulu
             if ($sbp->bast) {
                 $sbp->bast->delete();
             }
     
             // Hapus record SBP itu sendiri
             $sbp->delete();
         });
         $sbp->delete();
 
         // Redirect kembali dengan pesan sukses. Front-end akan me-reload halaman.
         return redirect()->back()->with('success', 'Data SBP dan dokumen terkait berhasil dihapus.');
         return redirect()->route('sbp.index')->with('success', 'Data SBP dan dokumen terkait berhasil dihapus.');
     }

    /**
     * Preview cetak SBP (iframe).
     */
    public function cetakPreview($id)
    {
        $sbp = Sbp::with(['petugas1', 'petugas2', 'bast'])->findOrFail($id);
        return view('preview-sbp', compact('sbp'));
    }

    /**
     * Generate PDF SBP (F4 FIX).
     */
    public function generatePdf($id)
    {
        $sbp = Sbp::with(['petugas1', 'petugas2'])->findOrFail($id);

        $pdf = Pdf::loadView('templatecetak.template-sbp', compact('sbp'))
            // ===== F4 REAL SIZE (pt) =====
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $sbp->nomor_sbp) . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Generate PDF BA Riksa (F4 FIX).
     */
    public function generatePdfBaRiksa($id)
    {
        $sbp = Sbp::with(['petugas1', 'petugas2'])->findOrFail($id);

        $pdf = Pdf::loadView('templatecetak.template-ba-riksa', compact('sbp'))
            // ===== F4 REAL SIZE (pt) =====
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $sbp->nomor_ba_riksa) . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Generate PDF BA Tegah (F4 FIX).
     */
    public function generatePdfBaTegah($id)
    {
        $sbp = Sbp::with(['petugas1', 'petugas2'])->findOrFail($id);

        $pdf = Pdf::loadView('templatecetak.template-ba-tegah', compact('sbp'))
            // ===== F4 REAL SIZE (pt) =====
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $sbp->nomor_ba_tegah) . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Generate PDF BA Segel (F4 FIX).
     */
    public function generatePdfBaSegel($id)
    {
        $sbp = Sbp::with(['petugas1', 'petugas2'])->findOrFail($id);

        $pdf = Pdf::loadView('templatecetak.template-ba-segel', compact('sbp'))
            // ===== F4 REAL SIZE (pt) =====
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $sbp->nomor_ba_segel) . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Generate PDF with all documents combined.
     */
    public function generatePdfSemua($id)
    {
        $sbp = Sbp::with(['petugas1', 'petugas2'])->findOrFail($id);

        $pdf = Pdf::loadView('templatecetak.template-semua', compact('sbp'))
            // F4 REAL SIZE (pt)
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $sbp->nomor_sbp) . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Generate PDF Checklist SBP.
     */
    public function generatePdfChecklist($id)
    {
        $sbp = Sbp::with(['petugas1', 'petugas2'])->findOrFail($id);

        $pdf = Pdf::loadView('templatecetak.template-checklist-sbp', compact('sbp'))
            // F4 REAL SIZE (pt)
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = 'Checklist' . str_replace('/', '-', $sbp->nomor_sbp) . '.pdf';

        return $pdf->stream($filename);
    }
    
    /**
     * Generate PDF BA Serah Terima (F4 FIX).
     */
    public function generatePdfBast($id)
    {
        $sbp = Sbp::with(['petugas1', 'bast'])->findOrFail($id);
        $bast = $sbp->bast;

        if (!$bast) {
            // Handle jika tidak ada BAST, bisa redirect atau tampilkan error
            return redirect()->back()->with('error', 'BAST tidak ditemukan untuk SBP ini.');
        }

        $pdf = Pdf::loadView('templatecetak.template-ba-serah-terima', compact('sbp', 'bast'))
            // ===== F4 REAL SIZE (pt) =====
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $bast->nomor_bast) . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Generate PDF BA Musnah (F4 FIX).
     */
    public function cetakBaMusnah(Sbp $sbp)
    {
        if (!$sbp->flag_ba_musnah || !$sbp->nomor_ba_musnah) {
            return redirect()->back()->with('error', 'Dokumen BA Musnah tidak tersedia untuk SBP ini.');
        }

        $pdf = Pdf::loadView('templatecetak.template-ba-musnah', compact('sbp'))
            // F4 REAL SIZE (pt)
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $sbp->nomor_ba_musnah) . '.pdf';

        return $pdf->stream($filename);
    }
}
