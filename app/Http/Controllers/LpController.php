<?php

namespace App\Http\Controllers;

use App\Models\Lp;
use App\Models\Lphp;
use App\Models\Petugas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LpController extends Controller
{
    public function index()
    {
        $lp = Lp::with(['lphp.sbp', 'pejabatPenerbit'])
            ->orderBy('tanggal_lp', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(request()->query());

        return view('lp.index', compact('lp'));
    }

    public function create(Request $request)
    {
        $lphp = null;

        if ($request->filled('lphp_id')) {
            $lphp = Lphp::with(['sbp', 'lp'])->find($request->query('lphp_id'));

            if ($lphp && $lphp->lp) {
                return redirect()->route('lphp.index')->with('error', 'LPHP ini sudah memiliki Laporan Pelanggaran.');
            }
        }

        if (!$lphp) {
            return redirect()->route('lphp.index')->with('error', 'Pilih LPHP dari halaman Data LPHP untuk membuat Laporan Pelanggaran.');
        }

        $petugasData = Petugas::orderBy('nama')->get();

        return view('lp.create', compact('lphp', 'petugasData'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lphp_id'             => ['required', 'exists:lphp,id', Rule::unique('lp', 'lphp_id')->whereNull('deleted_at')],
            'tanggal_lp'           => 'required|date',
            'pejabat_penerbit_id'  => 'required|exists:petugas,id',
        ]);

        try {
            DB::transaction(function () use ($validatedData) {
                $lphp = Lphp::findOrFail($validatedData['lphp_id']);

                $year = Carbon::parse($validatedData['tanggal_lp'])->year;
                $validatedData['nomor_lp'] = Lp::formatNomorLp($lphp->sbp->nomor_sbp_int, $year);

                Lp::create($validatedData);
            });

            return redirect()->route('lp.index')->with('success', 'Laporan Pelanggaran berhasil dibuat.');
        } catch (\Exception $e) {
            logger()->error('Failed to create LP: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat Laporan Pelanggaran. Silakan coba lagi.')->withInput();
        }
    }

    public function edit(Lp $lp)
    {
        $lp->load('lphp.sbp');
        $petugasData = Petugas::orderBy('nama')->get();

        return view('lp.edit', compact('lp', 'petugasData'));
    }

    public function update(Request $request, Lp $lp)
    {
        $validatedData = $request->validate([
            'tanggal_lp'           => 'required|date',
            'pejabat_penerbit_id'  => 'required|exists:petugas,id',
        ]);

        try {
            DB::transaction(function () use ($validatedData, $lp) {
                $year = Carbon::parse($validatedData['tanggal_lp'])->year;
                $validatedData['nomor_lp'] = Lp::formatNomorLp($lp->lphp->sbp->nomor_sbp_int, $year);

                $lp->update($validatedData);
            });

            return redirect()->route('lp.index')->with('success', 'Laporan Pelanggaran berhasil diupdate.');
        } catch (\Exception $e) {
            logger()->error('LP gagal diupdate: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui Laporan Pelanggaran. Silakan coba lagi.')->withInput();
        }
    }

    public function destroy(Lp $lp)
    {
        $lp->delete();

        return redirect()->route('lp.index')->with('success', 'Laporan Pelanggaran berhasil dihapus.');
    }

    public function preview($id)
    {
        $lp = Lp::with(['lphp.sbp.petugas1', 'lphp.sbp.petugas2', 'lphp.konseptor', 'pejabatPenerbit'])->findOrFail($id);

        $pdf = Pdf::loadView('templatecetak.template-lp', compact('lp'))
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $lp->nomor_lp) . '.pdf';

        return $pdf->stream($filename);
    }
}
