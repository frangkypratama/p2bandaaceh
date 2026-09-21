<?php

namespace App\Http\Controllers;

use App\Models\Lpf;
use App\Models\Petugas;
use App\Models\Split;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SplitController extends Controller
{
    public function index()
    {
        $split = Split::with(['lpf.lpp.lp.lphp.sbp'])
            ->orderBy('tanggal_split', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(request()->query());

        return view('split.index', compact('split'));
    }

    public function create(Request $request)
    {
        $lpf = null;

        if ($request->filled('lpf_id')) {
            $lpf = Lpf::with(['lpp.lp.lphp.sbp', 'split'])->find($request->query('lpf_id'));

            if ($lpf && $lpf->split) {
                return redirect()->route('lpf.index')->with('error', 'LPF ini sudah memiliki SPLIT.');
            }
        }

        if (!$lpf) {
            return redirect()->route('lpf.index')->with('error', 'Pilih LPF dari halaman Data LPF untuk membuat SPLIT.');
        }

        $lp = $lpf->lpp->lp;
        $petugasData = Petugas::orderBy('nama')->get();
        $defaultDasar = Split::defaultDasar($lp);
        $defaultPertimbangan = Split::defaultPertimbangan();
        $defaultUraianTugas = Split::defaultUraianTugas($lp);

        return view('split.create', compact('lpf', 'petugasData', 'defaultDasar', 'defaultPertimbangan', 'defaultUraianTugas'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lpf_id'         => ['required', 'exists:lpf,id', Rule::unique('split', 'lpf_id')->whereNull('deleted_at')],
            'tanggal_split'  => 'required|date',
            'dasar'          => 'required|string',
            'pertimbangan'   => 'required|string',
            'petugas1_id'    => 'required|exists:petugas,id',
            'petugas2_id'    => 'required|exists:petugas,id',
            'uraian_tugas'   => 'nullable|string',
            'penerbit_id'    => 'required|exists:petugas,id',
        ]);

        try {
            DB::transaction(function () use ($validatedData) {
                $lpf = Lpf::with('lpp.lp.lphp.sbp')->findOrFail($validatedData['lpf_id']);

                $year = Carbon::parse($validatedData['tanggal_split'])->year;
                $validatedData['nomor_split'] = Split::formatNomorSplit($lpf->lpp->lp->lphp->sbp->nomor_sbp_int, $year);

                Split::create($validatedData);
            });

            return redirect()->route('split.index')->with('success', 'SPLIT berhasil dibuat.');
        } catch (\Exception $e) {
            logger()->error('Failed to create SPLIT: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat SPLIT. Silakan coba lagi.')->withInput();
        }
    }

    public function edit(Split $split)
    {
        $split->load('lpf.lpp.lp.lphp.sbp');
        $petugasData = Petugas::orderBy('nama')->get();

        return view('split.edit', compact('split', 'petugasData'));
    }

    public function update(Request $request, Split $split)
    {
        $validatedData = $request->validate([
            'tanggal_split'  => 'required|date',
            'dasar'          => 'required|string',
            'pertimbangan'   => 'required|string',
            'petugas1_id'    => 'required|exists:petugas,id',
            'petugas2_id'    => 'required|exists:petugas,id',
            'uraian_tugas'   => 'nullable|string',
            'penerbit_id'    => 'required|exists:petugas,id',
        ]);

        try {
            DB::transaction(function () use ($validatedData, $split) {
                $year = Carbon::parse($validatedData['tanggal_split'])->year;
                $validatedData['nomor_split'] = Split::formatNomorSplit($split->lpf->lpp->lp->lphp->sbp->nomor_sbp_int, $year);

                $split->update($validatedData);
            });

            return redirect()->route('split.index')->with('success', 'SPLIT berhasil diupdate.');
        } catch (\Exception $e) {
            logger()->error('SPLIT gagal diupdate: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui SPLIT. Silakan coba lagi.')->withInput();
        }
    }

    public function destroy(Split $split)
    {
        $split->delete();

        return redirect()->route('split.index')->with('success', 'SPLIT berhasil dihapus.');
    }

    public function preview($id)
    {
        $split = Split::with(['lpf.lpp.lp.lphp.sbp', 'petugas1', 'petugas2', 'penerbit'])->findOrFail($id);

        $pdf = Pdf::loadView('templatecetak.template-split', compact('split'))
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $split->nomor_split) . '.pdf';

        return $pdf->stream($filename);
    }
}
