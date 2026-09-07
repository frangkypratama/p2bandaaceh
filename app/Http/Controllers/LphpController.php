<?php

namespace App\Http\Controllers;

use App\Models\Lphp;
use App\Models\Petugas;
use App\Models\Sbp;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LphpController extends Controller
{
    public function index()
    {
        $lphp = Lphp::with(['sbp', 'konseptor', 'pengampu', 'pemeriksa', 'lp'])
            ->orderBy('tanggal_lphp', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(request()->query());

        return view('lphp.index', compact('lphp'));
    }

    public function create(Request $request)
    {
        $sbp = null;

        if ($request->filled('sbp_id')) {
            $sbp = Sbp::with('lphp')->find($request->query('sbp_id'));

            if ($sbp && $sbp->lphp) {
                return redirect()->route('sbp.index')->with('error', 'SBP ini sudah memiliki LPHP.');
            }
        }

        if (!$sbp) {
            return redirect()->route('sbp.index')->with('error', 'Pilih SBP dari halaman Data SBP untuk membuat LPHP.');
        }

        $petugasData = Petugas::orderBy('nama')->get();

        return view('lphp.create', compact('sbp', 'petugasData'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sbp_id'             => ['required', 'exists:sbp,id', Rule::unique('lphp', 'sbp_id')->whereNull('deleted_at')],
            'tanggal_lphp'        => 'required|date',
            'dugaan_pelanggaran'  => 'required|string|max:255',
            'nama_tempat'         => 'nullable|string|max:255',
            'pasal'               => 'required|string|max:255',
            'uu_terkait'          => 'required|string',
            'konseptor_id'        => 'required|exists:petugas,id',
            'pengampu_id'         => 'required|exists:petugas,id',
            'pemeriksa_id'        => 'required|exists:petugas,id',
            'catatan'             => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($validatedData) {
                $sbp = Sbp::findOrFail($validatedData['sbp_id']);

                $year = Carbon::parse($validatedData['tanggal_lphp'])->year;
                $validatedData['nomor_lphp'] = Lphp::formatNomorLphp($sbp->nomor_sbp_int, $year);

                Lphp::create($validatedData);
            });

            return redirect()->route('lphp.index')->with('success', 'LPHP berhasil dibuat.');
        } catch (\Exception $e) {
            logger()->error('Failed to create LPHP: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat LPHP. Silakan coba lagi.')->withInput();
        }
    }

    public function edit(Lphp $lphp)
    {
        $lphp->load('sbp');
        $petugasData = Petugas::orderBy('nama')->get();

        return view('lphp.edit', compact('lphp', 'petugasData'));
    }

    public function update(Request $request, Lphp $lphp)
    {
        $validatedData = $request->validate([
            'tanggal_lphp'        => 'required|date',
            'dugaan_pelanggaran'  => 'required|string|max:255',
            'nama_tempat'         => 'nullable|string|max:255',
            'pasal'               => 'required|string|max:255',
            'uu_terkait'          => 'required|string',
            'konseptor_id'        => 'required|exists:petugas,id',
            'pengampu_id'         => 'required|exists:petugas,id',
            'pemeriksa_id'        => 'required|exists:petugas,id',
            'catatan'             => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($validatedData, $lphp) {
                $year = Carbon::parse($validatedData['tanggal_lphp'])->year;
                $validatedData['nomor_lphp'] = Lphp::formatNomorLphp($lphp->sbp->nomor_sbp_int, $year);

                $lphp->update($validatedData);
            });

            return redirect()->route('lphp.index')->with('success', 'LPHP berhasil diupdate.');
        } catch (\Exception $e) {
            logger()->error('LPHP gagal diupdate: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui LPHP. Silakan coba lagi.')->withInput();
        }
    }

    public function destroy(Lphp $lphp)
    {
        $lphp->delete();

        return redirect()->route('lphp.index')->with('success', 'LPHP berhasil dihapus.');
    }

    public function preview($id)
    {
        $lphp = Lphp::with(['sbp.petugas1', 'sbp.petugas2', 'konseptor', 'pengampu', 'pemeriksa'])->findOrFail($id);

        $pdf = Pdf::loadView('templatecetak.template-lphp', compact('lphp'))
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $lphp->nomor_lphp) . '.pdf';

        return $pdf->stream($filename);
    }
}
