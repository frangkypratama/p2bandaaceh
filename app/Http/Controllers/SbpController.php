<?php

namespace App\Http\Controllers;

use App\Exports\SbpExport;
use App\Http\Requests\StoreSbpRequest;
use App\Http\Requests\UpdateSbpRequest;
use App\Models\Sbp;
use App\Models\Petugas;
use App\Models\Lpt;
use App\Models\Bast;
use App\Models\RefPelanggaran;
use App\Models\RefSatuan;
use App\Models\RefJenisBarang;
use App\Models\SuratPerintah;
use App\Services\SbpService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class SbpController extends Controller
{
    /**
     * Export SBP data to Excel.
     */
    public function exportExcel(Request $request)
    {
        $search = $request->input('search');
        $startDate = null;
        $endDate = null;
        $filename = 'Data_SBP_' . now()->format('d-m-Y') . '.xlsx'; // Default filename

        if ($request->filled('date_range')) {
            $dateRange = explode(' - ', $request->input('date_range'));
            $startDate = $dateRange[0] ?? null;
            $endDate = $dateRange[1] ?? $startDate; // Use start date if end date is missing

            if ($startDate && $endDate) {
                // Parse the dates to format them correctly for the filename
                $formattedStartDate = Carbon::parse($startDate)->format('d-m-Y');
                $formattedEndDate = Carbon::parse($endDate)->format('d-m-Y');
                
                // If start and end date are the same, just use one date in the name
                if ($formattedStartDate == $formattedEndDate) {
                    $filename = 'Data_SBP_' . $formattedStartDate . '.xlsx';
                } else {
                    $filename = 'Data_SBP_' . $formattedStartDate . ' - ' . $formattedEndDate . '.xlsx';
                }
            }
        }

        return Excel::download(new SbpExport($search, $startDate, $endDate), $filename);
    }

    /**
     * Get the last SBP number and return the next one.
     */
    public function getLastNumber()
    {
        try {
            $currentYear = now()->year;

            $lastSbp = Sbp::whereYear('tanggal_sbp', $currentYear)
                ->orderBy('nomor_sbp_int', 'desc')
                ->first();

            $nextNumber = $lastSbp ? $lastSbp->nomor_sbp_int + 1 : 1;

            return response()->json(['next_number' => $nextNumber]);

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Failed to get last SBP number: " . $e->getMessage());
            
            // Return a generic error response
            return response()->json(['error' => 'Gagal mengambil nomor SBP terakhir.'], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sbp::with(['petugas1', 'petugas2', 'bast']);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nomor_sbp', 'like', "%{$search}%")
                  ->orWhere('nama_pelaku', 'like', "%{$search}%")
                  ->orWhere('jenis_identitas', 'like', "%{$search}%")
                  ->orWhere('nomor_identitas', 'like', "%{$search}%")
                  ->orWhere('jenis_barang', 'like', "%{$search}%");
            });
        }

        // Apply date range filter
        if ($request->filled('date_range')) {
            $dateRange = explode(' - ', $request->input('date_range'));
            $startDate = $dateRange[0] ?? null;
            $endDate = $dateRange[1] ?? $startDate; // Use start date if end date is missing
            
            if ($startDate) {
                $query->whereDate('tanggal_sbp', '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate('tanggal_sbp', '<=', $endDate);
            }
        }

        $sbpData = $query->orderBy('tanggal_sbp', 'desc')
                         ->orderBy('nomor_sbp_int', 'desc')
                         ->paginate(10)
                         ->appends($request->query()); // Append all query parameters to pagination links

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
        $suratPerintahData = SuratPerintah::orderBy('tanggal_prin', 'desc')->get();
        $jenisBarang = RefJenisBarang::orderBy('nomor_urut', 'asc')->get();

        return view('input-sbp', compact('petugasData', 'refPelanggaranData', 'refSatuanData', 'suratPerintahData', 'jenisBarang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSbpRequest $request, SbpService $sbpService)
    {
        $result = $sbpService->store($request);

        return $this->redirectAfterSave(
            "{$result['sbp']->nomor_sbp} berhasil disimpan.",
            $result
        );
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
        $suratPerintahData = SuratPerintah::orderBy('tanggal_prin', 'desc')->get();
        $jenisBarang = RefJenisBarang::orderBy('nomor_urut', 'asc')->get();

        return view('edit-sbp', compact('sbp', 'petugasData', 'refPelanggaranData', 'refSatuanData', 'suratPerintahData', 'jenisBarang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSbpRequest $request, Sbp $sbp, SbpService $sbpService)
    {
        $result = $sbpService->update($sbp, $request);

        return $this->redirectAfterSave('Data SBP berhasil diperbarui.', $result);
    }

    /**
     * Redirect ke index setelah simpan, sekaligus notifikasi kalau SbpService sempat
     * menaikkan nomor SBP secara otomatis karena kena race condition (nomor yang diminta
     * baru saja dipakai proses lain).
     */
    private function redirectAfterSave(string $successMessage, array $result)
    {
        $redirect = redirect()->route('sbp.index')->with('success', $successMessage);

        if ($result['auto_adjusted']) {
            $redirect->with(
                'warning',
                "Nomor SBP {$result['requested_nomor']} baru saja dipakai oleh proses lain secara bersamaan. "
                    . "Sistem otomatis menggunakan nomor berikutnya: {$result['sbp']->nomor_sbp}."
            );
        }

        return $redirect;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sbp $sbp)
    {
        try {
            // The 'deleting' event on the Sbp model automatically handles the deletion 
            // of the related BAST record. No need for transactions or manual deletion here.
            $sbp->delete();

            // Redirect to the index page with a success message.
            return redirect()->route('sbp.index')->with('success', 'Data SBP dan dokumen terkait berhasil dihapus.');

        } catch (\Exception $e) {
            // Log the error for debugging purposes.
            Log::error("Gagal menghapus SBP #{$sbp->id}: " . $e->getMessage());

            // Redirect back with an error message.
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data SBP.');
        }
    }

    /**
     * Preview cetak SBP (iframe).
     */
    public function cetakPreview(Request $request, $id)
    {
        $sbp = Sbp::with(['petugas1', 'petugas2', 'bast'])->findOrFail($id);

        $back = $request->query('back');

        // Validate the back URL to prevent open redirect vulnerabilities.
        // It must be a local URL from the same host as the app.
        $appHost = parse_url(config('app.url'), PHP_URL_HOST);
        $safeBack = $back && parse_url($back, PHP_URL_HOST) === $appHost
            ? $back
            : route('sbp.index');

        return view('preview-sbp', compact('sbp', 'safeBack'));
    }

    /**
     * Render view PDF ke ukuran kertas F4 (dipakai bersama oleh semua method cetak PDF SBP).
     */
    private function renderPdf(string $view, array $data, string $filename)
    {
        $pdf = Pdf::loadView($view, $data)
            // ===== F4 REAL SIZE (pt) =====
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        return $pdf->stream($filename);
    }

    /**
     * Generate PDF SBP (F4 FIX).
     */
    public function generatePdf($id)
    {
        $sbp = Sbp::with(['petugas1', 'petugas2'])->findOrFail($id);

        return $this->renderPdf(
            'templatecetak.template-sbp',
            compact('sbp'),
            str_replace('/', '-', $sbp->nomor_sbp) . '.pdf'
        );
    }

    /**
     * Generate PDF BA Riksa (F4 FIX).
     */
    public function generatePdfBaRiksa($id)
    {
        $sbp = Sbp::with(['petugas1', 'petugas2'])->findOrFail($id);

        return $this->renderPdf(
            'templatecetak.template-ba-riksa',
            compact('sbp'),
            str_replace('/', '-', $sbp->nomor_ba_riksa) . '.pdf'
        );
    }

    /**
     * Generate PDF BA Tegah (F4 FIX).
     */
    public function generatePdfBaTegah($id)
    {
        $sbp = Sbp::with(['petugas1', 'petugas2'])->findOrFail($id);

        return $this->renderPdf(
            'templatecetak.template-ba-tegah',
            compact('sbp'),
            str_replace('/', '-', $sbp->nomor_ba_tegah) . '.pdf'
        );
    }

    /**
     * Generate PDF BA Segel (F4 FIX).
     */
    public function generatePdfBaSegel($id)
    {
        $sbp = Sbp::with(['petugas1', 'petugas2'])->findOrFail($id);

        return $this->renderPdf(
            'templatecetak.template-ba-segel',
            compact('sbp'),
            str_replace('/', '-', $sbp->nomor_ba_segel) . '.pdf'
        );
    }

    /**
     * Generate PDF with all documents combined.
     */
    public function generatePdfSemua($id)
    {
        $sbp = Sbp::with(['petugas1', 'petugas2'])->findOrFail($id);

        return $this->renderPdf(
            'templatecetak.template-semua',
            compact('sbp'),
            str_replace('/', '-', $sbp->nomor_sbp) . '.pdf'
        );
    }

    /**
     * Generate PDF Checklist SBP.
     */
    public function generatePdfChecklist($id)
    {
        $sbp = Sbp::with(['petugas1', 'petugas2', 'bast', 'lpt'])->findOrFail($id);

        $checklistItems = [
            ['nama' => 'SURAT TUGAS (INTELIJEN)', 'status' => false],
            ['nama' => 'LAPORAN PELAKSANAAN TUGAS (INTELIJEN)', 'status' => false],
            ['nama' => 'LEMBAR PENGUMPULAN DAN PENILAIAN INFORMASI (LPPI)', 'status' => false],
            ['nama' => 'LEMBAR KERJA ANALISIS INTELIJEN (LKAI)', 'status' => false],
            ['nama' => 'NOTA HASIL INTELIJEN (NHI)', 'status' => false],
            ['nama' => 'NOTA INFORMASI (NI)', 'status' => false],
            ['nama' => 'LEMBAR INFORMasi (LI-1)', 'status' => false],
            ['nama' => 'LEMBAR ANALISIS PRAPENINDAKAN (LAP)', 'status' => false],
            ['nama' => 'NOTA PENGEMBALIAN INFORMASI (NPI)', 'status' => false],
            ['nama' => 'MEMO PELIMPAHAN PENINDAKAN (MPP)', 'status' => false],
            ['nama' => 'SURAT PERINTAH (PENINDAKAN)*', 'status' => !empty($sbp->nomor_surat_perintah)],
            ['nama' => 'BERITA ACARA PEMERIKSAAN*', 'status' => !empty($sbp->nomor_ba_riksa)],
            ['nama' => 'BERITA ACARA PENGAMBILAN CONTOH BARANG', 'status' => false],
            ['nama' => 'BERITA ACARA PENEGAHAN*', 'status' => !empty($sbp->nomor_ba_tegah)],
            ['nama' => 'BERITA ACARA PENYEGELAN*', 'status' => !empty($sbp->nomor_ba_segel)],
            ['nama' => 'BERITA ACARA PENGAMBILAN DOKUMENTASI', 'status' => false],
            ['nama' => 'BERITA ACARA MEMBAWA SARANA PENGANGKUT DAN/ATAU BARANG', 'status' => false],
            ['nama' => 'SURAT BUKTI PENINDAKAN (SBP)*', 'status' => !empty($sbp->nomor_sbp)],
            ['nama' => 'BERITA ACARA PENOLAKAN TANDA TANGAN SURAT BUKTI PENINDAKAN', 'status' => false],
            ['nama' => 'BERITA ACARA PENOLAKAN TANDA TANGAN TERHADAP BERITA ACARA PENOLAKAN TANDA TANGAN SURAT BUKTI PENINDAKAN', 'status' => false],
            ['nama' => 'PENINDAKAN SEGERA', 'status' => false],
            ['nama' => 'LAPORAN PELAKSANAAN TUGAS (LPT)*', 'status' => !empty($sbp->lpt)],
            ['nama' => 'LAPORAN DAN PENENTUAN HASIL PENINDAKAN (LPHP)*', 'status' => false],
            ['nama' => 'LAPORAN PELANGGARAN (LP)*', 'status' => false],
            ['nama' => 'BERITA ACARA SERAH TERIMA (BAST KE PENYIDIKAN)', 'status' => !empty($sbp->bast)],
            ['nama' => 'BERITA ACARA PEMUSNAHAN', 'status' => !empty($sbp->nomor_ba_musnah)],
            ['nama' => 'LEMBAR PENERIMAAN PERKARA (LPP)*', 'status' => false],
            ['nama' => 'LEMBAR PENELITIAN FORMAL (LPF)*', 'status' => false],
            ['nama' => 'LAPORAN PELANGGARAN DARI UNIT/INSTANSI LAIN (LP-1)', 'status' => false],
            ['nama' => 'SURAT PERINTAH PENELITIAN (SPLIT)*', 'status' => false],
            ['nama' => 'LEMBAR HASIL PENELITIAN (LHP)*', 'status' => false],
            ['nama' => 'LEMBAR RESUME PERKARA (LRP)*', 'status' => false],
            ['nama' => 'BERITA ACARA PENCACAHAN', 'status' => false],
            ['nama' => 'KEP BDN', 'status' => false],
            ['nama' => 'BERITA ACARA WAWANCARA', 'status' => false],
            ['nama' => 'Lainnya........................', 'status' => false],
        ];

        return $this->renderPdf(
            'templatecetak.template-checklist-sbp',
            compact('sbp', 'checklistItems'),
            'Checklist ' . str_replace('/', '-', $sbp->nomor_sbp) . '.pdf'
        );
    }

    /**
     * Generate PDF Label Barang (12cm x 8cm).
     */
    public function generatePdfLabel($id)
    {
        $sbp = Sbp::with(['petugas1', 'petugas2'])->findOrFail($id);

        return $this->renderPdf(
            'templatecetak.template-label-barang',
            compact('sbp'),
            'Label Barang ' . str_replace('/', '-', $sbp->nomor_sbp) . '.pdf'
        );
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

        return $this->renderPdf(
            'templatecetak.template-ba-serah-terima',
            compact('sbp', 'bast'),
            str_replace('/', '-', $bast->nomor_bast) . '.pdf'
        );
    }

    /**
     * Generate PDF BA Musnah (F4 FIX).
     */
    public function cetakBaMusnah(Sbp $sbp)
    {
        if (!$sbp->flag_ba_musnah || !$sbp->nomor_ba_musnah) {
            return redirect()->back()->with('error', 'Dokumen BA Musnah tidak tersedia untuk SBP ini.');
        }

        return $this->renderPdf(
            'templatecetak.template-ba-musnah',
            compact('sbp'),
            str_replace('/', '-', $sbp->nomor_ba_musnah) . '.pdf'
        );
    }

    /**
     * Return SBP data as JSON for API calls.
     */
    public function showApi($id)
    {
        $sbp = Sbp::findOrFail($id);
        return response()->json($sbp);
    }
}
