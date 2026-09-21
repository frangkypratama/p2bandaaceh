<?php

namespace App\Http\Controllers;

use App\Models\Lhp;
use App\Models\Petugas;
use App\Models\Split;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LhpController extends Controller
{
    public function index()
    {
        $lhp = Lhp::with(['split.lpf.lpp.lp.lphp.sbp'])
            ->orderBy('tanggal_lhp', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(request()->query());

        return view('lhp.index', compact('lhp'));
    }

    public function create(Request $request)
    {
        $split = null;

        if ($request->filled('split_id')) {
            $split = Split::with(['lpf.lpp.lp.lphp.sbp', 'lhp'])->find($request->query('split_id'));

            if ($split && $split->lhp) {
                return redirect()->route('split.index')->with('error', 'SPLIT ini sudah memiliki LHP.');
            }
        }

        if (!$split) {
            return redirect()->route('split.index')->with('error', 'Pilih SPLIT dari halaman Data SPLIT untuk membuat LHP.');
        }

        $petugasData = Petugas::orderBy('nama')->get();
        $sbp = optional(optional(optional($split->lpf)->lpp)->lp)->lphp?->sbp;
        $defaultJenisPelanggaran = optional(optional($split->lpf->lpp->lp)->lphp)->dugaan_pelanggaran ?? 'Kepabeanan';

        return view('lhp.create', compact('split', 'petugasData', 'sbp', 'defaultJenisPelanggaran'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'split_id'                  => ['required', 'exists:split,id', Rule::unique('lhp', 'split_id')->whereNull('deleted_at')],
            'tanggal_lhp'                => 'required|date',
            'jenis_pelanggaran'          => 'required|string|max:255',
            'pelaku_administrasi'        => 'nullable|string',
            'saksi_saksi'                => 'nullable|string',
            'uraian_barang_tambahan'     => 'nullable|string',
            'sarana_pengangkut'          => 'nullable|string',
            'dokumen_dokumen'            => 'nullable|string',
            'modus_pelanggaran'          => 'required|string',
            'pemenuhan_unsur_pasal'      => 'required|string',
            'kesimpulan'                 => 'required|string',
            'alternatif_penyelesaian'    => 'nullable|string',
            'informasi_lainnya'          => 'nullable|string',
            'catatan_atasan'             => 'nullable|string',
            'konseptor_id'               => 'required|exists:petugas,id',
            'pengampu_id'                => 'required|exists:petugas,id',
            'pemeriksa_id'               => 'required|exists:petugas,id',
        ]);

        try {
            DB::transaction(function () use ($validatedData) {
                $split = Split::with('lpf.lpp.lp.lphp.sbp')->findOrFail($validatedData['split_id']);

                $year = Carbon::parse($validatedData['tanggal_lhp'])->year;
                $validatedData['nomor_lhp'] = Lhp::formatNomorLhp($split->lpf->lpp->lp->lphp->sbp->nomor_sbp_int, $year);

                Lhp::create($validatedData);
            });

            return redirect()->route('lhp.index')->with('success', 'LHP berhasil dibuat.');
        } catch (\Exception $e) {
            logger()->error('Failed to create LHP: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat LHP. Silakan coba lagi.')->withInput();
        }
    }

    public function edit(Lhp $lhp)
    {
        $lhp->load('split.lpf.lpp.lp.lphp.sbp');
        $petugasData = Petugas::orderBy('nama')->get();
        $sbp = optional(optional(optional($lhp->split->lpf)->lpp)->lp)->lphp?->sbp;

        return view('lhp.edit', compact('lhp', 'petugasData', 'sbp'));
    }

    public function update(Request $request, Lhp $lhp)
    {
        $validatedData = $request->validate([
            'tanggal_lhp'                => 'required|date',
            'jenis_pelanggaran'          => 'required|string|max:255',
            'pelaku_administrasi'        => 'nullable|string',
            'saksi_saksi'                => 'nullable|string',
            'uraian_barang_tambahan'     => 'nullable|string',
            'sarana_pengangkut'          => 'nullable|string',
            'dokumen_dokumen'            => 'nullable|string',
            'modus_pelanggaran'          => 'required|string',
            'pemenuhan_unsur_pasal'      => 'required|string',
            'kesimpulan'                 => 'required|string',
            'alternatif_penyelesaian'    => 'nullable|string',
            'informasi_lainnya'          => 'nullable|string',
            'catatan_atasan'             => 'nullable|string',
            'konseptor_id'               => 'required|exists:petugas,id',
            'pengampu_id'                => 'required|exists:petugas,id',
            'pemeriksa_id'               => 'required|exists:petugas,id',
        ]);

        try {
            DB::transaction(function () use ($validatedData, $lhp) {
                $year = Carbon::parse($validatedData['tanggal_lhp'])->year;
                $validatedData['nomor_lhp'] = Lhp::formatNomorLhp($lhp->split->lpf->lpp->lp->lphp->sbp->nomor_sbp_int, $year);

                $lhp->update($validatedData);
            });

            return redirect()->route('lhp.index')->with('success', 'LHP berhasil diupdate.');
        } catch (\Exception $e) {
            logger()->error('LHP gagal diupdate: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui LHP. Silakan coba lagi.')->withInput();
        }
    }

    public function destroy(Lhp $lhp)
    {
        $lhp->delete();

        return redirect()->route('lhp.index')->with('success', 'LHP berhasil dihapus.');
    }

    public function preview($id)
    {
        $lhp = Lhp::with(['split.lpf.lpp.lp.lphp.sbp', 'konseptor', 'pengampu', 'pemeriksa'])->findOrFail($id);

        $pdf = Pdf::loadView('templatecetak.template-lhp', compact('lhp'))
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $lhp->nomor_lhp) . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Cetak gabungan seluruh berkas penyidikan (LP, LPP, LPF, SPLIT, LHP) dalam satu PDF,
     * mengikuti bundel "cetak_berkas_penyidikan" yang selama ini dicetak manual.
     */
    public function previewBerkas($id)
    {
        $lhp = Lhp::with([
            'split.lpf.lpp.lp.lphp.sbp.petugas1',
            'split.lpf.lpp.lp.lphp.sbp.petugas2',
            'split.lpf.lpp.lp.pejabatPenerbit',
            'split.lpf.lpp.konseptor',
            'split.lpf.lpp.pengampu',
            'split.lpf.lpp.pemeriksa',
            'split.lpf.konseptor',
            'split.lpf.pengampu',
            'split.lpf.pemeriksa',
            'split.petugas1',
            'split.petugas2',
            'split.penerbit',
            'konseptor',
            'pengampu',
            'pemeriksa',
        ])->findOrFail($id);

        $split = $lhp->split;
        $lpf = $split->lpf;
        $lpp = $lpf->lpp;
        $lp = $lpp->lp;

        $pdf = Pdf::loadView('templatecetak.template-berkas-penyidikan', compact('lp', 'lpp', 'lpf', 'split', 'lhp'))
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = 'Berkas-Penyidikan-' . str_replace('/', '-', $lp->nomor_lp) . '.pdf';

        return $pdf->stream($filename);
    }
}
