<?php

namespace App\Http\Controllers;

use App\Models\Lpf;
use App\Models\Lpp;
use App\Models\Petugas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LpfController extends Controller
{
    public function index()
    {
        $lpf = Lpf::with(['lpp.lp.lphp.sbp'])
            ->orderBy('tanggal_lpf', 'desc')
            ->orderBy('nomor_lpf', 'desc')
            ->paginate(10)
            ->appends(request()->query());

        return view('lpf.index', compact('lpf'));
    }

    public function pickLpp(Request $request)
    {
        $lppList = Lpp::with('lpf')
            ->orderBy('tanggal_lpp', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('lpf.partials.pilih-lpp-table', ['lpp' => $lppList]);
    }

    public function create(Request $request)
    {
        $lpp = null;

        if ($request->filled('lpp_id')) {
            $lpp = Lpp::with(['lp.lphp.sbp', 'lpf'])->find($request->query('lpp_id'));

            if ($lpp && $lpp->lpf) {
                return redirect()->route('lpp.index')->with('error', 'LPP ini sudah memiliki LPF.');
            }
        }

        if (!$lpp) {
            return redirect()->route('lpp.index')->with('error', 'Pilih LPP dari halaman Data LPP untuk membuat LPF.');
        }

        $petugasData = Petugas::orderBy('nama')->get();
        $defaultDomainPerkara = Lpf::defaultDomainPerkara();
        $opsiCukup = Lpf::opsiCukup();
        $opsiAda = Lpf::opsiAda();

        return view('lpf.create', compact('lpp', 'petugasData', 'defaultDomainPerkara', 'opsiCukup', 'opsiAda'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lpp_id'                   => ['required', 'exists:lpp,id', Rule::unique('lpf', 'lpp_id')->whereNull('deleted_at')],
            'tanggal_lpf'              => 'required|date',
            'status_penangkapan'       => 'required|string|max:255',
            'nomor_surat_limpahan'     => 'nullable|string|max:255',
            'tanggal_surat_limpahan'   => 'nullable|date',
            'nomor_baw_saksi'          => 'nullable|string|max:255',
            'tanggal_baw_saksi'        => 'nullable|date',
            'nomor_bap_tersangka'      => 'nullable|string|max:255',
            'tanggal_bap_tersangka'    => 'nullable|date',
            'nomor_resume_perkara'     => 'nullable|string|max:255',
            'tanggal_resume_perkara'   => 'nullable|date',
            'nomor_dokumen_lain'       => 'nullable|string|max:255',
            'tanggal_dokumen_lain'     => 'nullable|date',
            'barang_hasil_penindakan'  => 'nullable|string',
            'domain_perkara'           => 'required|string',
            'lengkap_berkas'           => ['required', Rule::in(Lpf::opsiCukup())],
            'cukup_barang_bukti'       => ['required', Rule::in(Lpf::opsiCukup())],
            'cukup_alat_bukti'         => ['required', Rule::in(Lpf::opsiCukup())],
            'keberadaan_pelaku'        => ['required', Rule::in(Lpf::opsiAda())],
            'keterkaitan_bukti_pelaku' => ['required', Rule::in(Lpf::opsiAda())],
            'indikasi_pelanggaran'     => ['required', Rule::in(Lpf::opsiAda())],
            'usulan'                   => 'required|string',
            'catatan_disposisi'        => 'nullable|string',
            'konseptor_id'             => 'required|exists:petugas,id',
            'pengampu_id'              => 'required|exists:petugas,id',
            'pemeriksa_id'             => 'required|exists:petugas,id',
        ]);

        $validatedData['kesimpulan'] = Lpf::composeKesimpulan(
            $validatedData['lengkap_berkas'],
            $validatedData['cukup_barang_bukti'],
            $validatedData['cukup_alat_bukti'],
            $validatedData['keberadaan_pelaku'],
            $validatedData['keterkaitan_bukti_pelaku'],
            $validatedData['indikasi_pelanggaran']
        );

        try {
            DB::transaction(function () use ($validatedData) {
                $lpp = Lpp::with('lp.lphp.sbp')->findOrFail($validatedData['lpp_id']);

                $year = Carbon::parse($validatedData['tanggal_lpf'])->year;
                $validatedData['nomor_lpf'] = Lpf::formatNomorLpf($lpp->lp->lphp->sbp->nomor_sbp_int, $year);

                Lpf::create($validatedData);
            });

            return redirect()->route('lpf.index')->with('success', 'LPF berhasil dibuat.');
        } catch (\Exception $e) {
            logger()->error('Failed to create LPF: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat LPF. Silakan coba lagi.')->withInput();
        }
    }

    public function edit(Lpf $lpf)
    {
        $lpf->load('lpp.lp.lphp.sbp');
        $petugasData = Petugas::orderBy('nama')->get();
        $opsiCukup = Lpf::opsiCukup();
        $opsiAda = Lpf::opsiAda();

        return view('lpf.edit', compact('lpf', 'petugasData', 'opsiCukup', 'opsiAda'));
    }

    public function update(Request $request, Lpf $lpf)
    {
        $validatedData = $request->validate([
            'tanggal_lpf'              => 'required|date',
            'status_penangkapan'       => 'required|string|max:255',
            'nomor_surat_limpahan'     => 'nullable|string|max:255',
            'tanggal_surat_limpahan'   => 'nullable|date',
            'nomor_baw_saksi'          => 'nullable|string|max:255',
            'tanggal_baw_saksi'        => 'nullable|date',
            'nomor_bap_tersangka'      => 'nullable|string|max:255',
            'tanggal_bap_tersangka'    => 'nullable|date',
            'nomor_resume_perkara'     => 'nullable|string|max:255',
            'tanggal_resume_perkara'   => 'nullable|date',
            'nomor_dokumen_lain'       => 'nullable|string|max:255',
            'tanggal_dokumen_lain'     => 'nullable|date',
            'barang_hasil_penindakan'  => 'nullable|string',
            'domain_perkara'           => 'required|string',
            'lengkap_berkas'           => ['required', Rule::in(Lpf::opsiCukup())],
            'cukup_barang_bukti'       => ['required', Rule::in(Lpf::opsiCukup())],
            'cukup_alat_bukti'         => ['required', Rule::in(Lpf::opsiCukup())],
            'keberadaan_pelaku'        => ['required', Rule::in(Lpf::opsiAda())],
            'keterkaitan_bukti_pelaku' => ['required', Rule::in(Lpf::opsiAda())],
            'indikasi_pelanggaran'     => ['required', Rule::in(Lpf::opsiAda())],
            'usulan'                   => 'required|string',
            'catatan_disposisi'        => 'nullable|string',
            'konseptor_id'             => 'required|exists:petugas,id',
            'pengampu_id'              => 'required|exists:petugas,id',
            'pemeriksa_id'             => 'required|exists:petugas,id',
        ]);

        $validatedData['kesimpulan'] = Lpf::composeKesimpulan(
            $validatedData['lengkap_berkas'],
            $validatedData['cukup_barang_bukti'],
            $validatedData['cukup_alat_bukti'],
            $validatedData['keberadaan_pelaku'],
            $validatedData['keterkaitan_bukti_pelaku'],
            $validatedData['indikasi_pelanggaran']
        );

        try {
            DB::transaction(function () use ($validatedData, $lpf) {
                $year = Carbon::parse($validatedData['tanggal_lpf'])->year;
                $validatedData['nomor_lpf'] = Lpf::formatNomorLpf($lpf->lpp->lp->lphp->sbp->nomor_sbp_int, $year);

                $lpf->update($validatedData);
            });

            return redirect()->route('lpf.index')->with('success', 'LPF berhasil diupdate.');
        } catch (\Exception $e) {
            logger()->error('LPF gagal diupdate: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui LPF. Silakan coba lagi.')->withInput();
        }
    }

    public function destroy(Lpf $lpf)
    {
        $lpf->delete();

        return redirect()->route('lpf.index')->with('success', 'LPF berhasil dihapus.');
    }

    public function preview($id)
    {
        $lpf = Lpf::with(['lpp.lp.lphp.sbp', 'konseptor', 'pengampu', 'pemeriksa'])->findOrFail($id);

        $pdf = Pdf::loadView('templatecetak.template-lpf', compact('lpf'))
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $filename = str_replace('/', '-', $lpf->nomor_lpf) . '.pdf';

        return $pdf->stream($filename);
    }
}
