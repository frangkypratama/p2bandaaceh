<?php

namespace App\Http\Controllers;

use App\Models\Lp;
use App\Models\Lpp;
use App\Models\Petugas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LppController extends Controller
{
    public function index()
    {
        $lpp = Lpp::with(['lp.lphp.sbp'])
            ->orderBy('tanggal_lpp', 'desc')
            ->orderBy('nomor_lpp', 'desc')
            ->paginate(10)
            ->appends(request()->query());

        return view('lpp.index', compact('lpp'));
    }

    /**
     * Daftar LP untuk modal pemilihan LP (dipakai dari halaman index sebelum
     * masuk ke form create), mengikuti pola pickSbp() di LphpController.
     */
    public function pickLp(Request $request)
    {
        $lpList = Lp::with('lpp')
            ->orderBy('tanggal_lp', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('lpp.partials.pilih-lp-table', ['lp' => $lpList]);
    }

    public function create(Request $request)
    {
        $lp = null;

        if ($request->filled('lp_id')) {
            $lp = Lp::with(['lphp.sbp', 'lpp'])->find($request->query('lp_id'));

            if ($lp && $lp->lpp) {
                return redirect()->route('lp.index')->with('error', 'LP ini sudah memiliki LPP.');
            }
        }

        if (!$lp) {
            return redirect()->route('lp.index')->with('error', 'Pilih LP dari halaman Data Laporan Pelanggaran untuk membuat LPP.');
        }

        $petugasData = Petugas::orderBy('nama')->get();

        return view('lpp.create', compact('lp', 'petugasData'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lp_id'               => ['required', 'exists:lp,id', Rule::unique('lpp', 'lp_id')->whereNull('deleted_at')],
            'tanggal_lpp'         => 'required|date',
            'asal_perkara'        => 'required|string|max:255',
            'jenis_penindakan'    => 'required|string|max:255',
            'status_pelanggaran'  => 'required|string|max:255',
            'uraian_pelanggaran'  => 'required|string',
            'dokumen_barang'      => 'nullable|string',
            'catatan_atasan'      => 'nullable|string',
            'konseptor_id'        => 'required|exists:petugas,id',
            'pengampu_id'         => 'required|exists:petugas,id',
            'pemeriksa_id'        => 'required|exists:petugas,id',
        ]);

        try {
            DB::transaction(function () use ($validatedData) {
                $lp = Lp::with('lphp.sbp')->findOrFail($validatedData['lp_id']);

                $year = Carbon::parse($validatedData['tanggal_lpp'])->year;
                $validatedData['nomor_lpp'] = Lpp::formatNomorLpp($lp->lphp->sbp->nomor_sbp_int, $year);

                Lpp::create($validatedData);
            });

            return redirect()->route('lpp.index')->with('success', 'LPP berhasil dibuat.');
        } catch (\Exception $e) {
            logger()->error('Failed to create LPP: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat LPP. Silakan coba lagi.')->withInput();
        }
    }

    public function edit(Lpp $lpp)
    {
        $lpp->load('lp.lphp.sbp');
        $petugasData = Petugas::orderBy('nama')->get();

        return view('lpp.edit', compact('lpp', 'petugasData'));
    }

    public function update(Request $request, Lpp $lpp)
    {
        $validatedData = $request->validate([
            'tanggal_lpp'         => 'required|date',
            'asal_perkara'        => 'required|string|max:255',
            'jenis_penindakan'    => 'required|string|max:255',
            'status_pelanggaran'  => 'required|string|max:255',
            'uraian_pelanggaran'  => 'required|string',
            'dokumen_barang'      => 'nullable|string',
            'catatan_atasan'      => 'nullable|string',
            'konseptor_id'        => 'required|exists:petugas,id',
            'pengampu_id'         => 'required|exists:petugas,id',
            'pemeriksa_id'        => 'required|exists:petugas,id',
        ]);

        try {
            DB::transaction(function () use ($validatedData, $lpp) {
                $year = Carbon::parse($validatedData['tanggal_lpp'])->year;
                $validatedData['nomor_lpp'] = Lpp::formatNomorLpp($lpp->lp->lphp->sbp->nomor_sbp_int, $year);

                $lpp->update($validatedData);
            });

            return redirect()->route('lpp.index')->with('success', 'LPP berhasil diupdate.');
        } catch (\Exception $e) {
            logger()->error('LPP gagal diupdate: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui LPP. Silakan coba lagi.')->withInput();
        }
    }

    public function destroy(Lpp $lpp)
    {
        $lpp->delete();

        return redirect()->route('lpp.index')->with('success', 'LPP berhasil dihapus.');
    }

    public function preview($id)
    {
        $lpp = Lpp::with(['lp.lphp.sbp.petugas1', 'lp.lphp.sbp.petugas2', 'lp.pejabatPenerbit', 'konseptor', 'pengampu', 'pemeriksa'])->findOrFail($id);

        $pdf = Pdf::loadView('templatecetak.template-lpp', compact('lpp'))
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $lpp->nomor_lpp) . '.pdf';

        return $pdf->stream($filename);
    }
}
