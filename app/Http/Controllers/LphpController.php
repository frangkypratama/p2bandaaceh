<?php

namespace App\Http\Controllers;

use App\Models\Lphp;
use App\Models\Petugas;
use App\Models\Sbp;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LphpController extends Controller
{
    /**
     * Daftar kewarganegaraan untuk dropdown pencarian (select2).
     */
    private function getNationalities(): Collection
    {
        $nationalities = [
            "Afghanistan", "Albania", "Aljazair", "Amerika Serikat", "Andorra", "Angola", "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan",
            "Bahama", "Bahrain", "Bangladesh", "Barbados", "Belanda", "Belarus", "Belgia", "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia dan Herzegovina", "Botswana", "Brasil", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi",
            "Ceko", "Chad", "Cile",
            "Denmark", "Djibouti", "Dominika",
            "Ekuador", "El Salvador", "Eritrea", "Estonia", "Eswatini", "Ethiopia",
            "Fiji", "Filipina", "Finlandia",
            "Gabon", "Gambia", "Georgia", "Ghana", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana",
            "Haiti", "Honduras", "Hungaria",
            "India", "Indonesia", "Inggris", "Irak", "Iran", "Irlandia", "Islandia", "Israel", "Italia",
            "Jamaika", "Jepang", "Jerman",
            "Kamboja", "Kamerun", "Kanada", "Kazakhstan", "Kenya", "Kirgistan", "Kiribati", "Kolombia", "Komoro", "Kongo", "Korea Selatan", "Korea Utara", "Kosta Rika", "Kroasia", "Kuba", "Kuwait",
            "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lituania", "Luksemburg",
            "Madagaskar", "Maladewa", "Malawi", "Malaysia", "Mali", "Malta", "Maroko", "Marshall", "Mauritania", "Mauritius", "Meksiko", "Mesir", "Mikronesia", "Moldova", "Monako", "Mongolia", "Montenegro", "Mozambik", "Myanmar",
            "Namibia", "Nauru", "Nepal", "Nikaragua", "Niger", "Nigeria", "Norwegia",
            "Oman",
            "Pakistan", "Palau", "Panama", "Pantai Gading", "Papua Nugini", "Paraguay", "Peru", "Polandia", "Portugal",
            "Prancis",
            "Qatar",
            "Rumania", "Rusia", "Rwanda",
            "Saint Kitts dan Nevis", "Saint Lucia", "Saint Vincent dan Grenadine", "Samoa", "San Marino", "Sao Tome dan Principe", "Selandia Baru", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapura", "Siprus", "Slovenia", "Slowakia", "Solomon", "Somalia", "Spanyol", "Sri Lanka", "Sudan", "Sudan Selatan", "Suriah", "Suriname", "Swedia", "Swiss",
            "Tajikistan", "Tanjung Verde", "Tanzania", "Thailand", "Timor Leste", "Tiongkok", "Togo", "Tonga", "Trinidad dan Tobago", "Tunisia", "Turki", "Turkmenistan", "Tuvalu",
            "Uganda", "Ukraina", "Uni Emirat Arab", "Uruguay", "Uzbekistan",
            "Vanuatu", "Vatikan", "Venezuela", "Vietnam",
            "Yaman", "Yordania", "Yunani",
            "Zambia", "Zimbabwe"
        ];

        return collect($nationalities)->sort()->values();
    }

    public function index()
    {
        $lphp = Lphp::with(['sbp', 'konseptor', 'pengampu', 'pemeriksa', 'lp'])
            ->join('sbp', 'sbp.id', '=', 'lphp.sbp_id')
            ->select('lphp.*')
            ->orderBy('lphp.tanggal_lphp', 'desc')
            ->orderBy('sbp.nomor_sbp_int', 'desc')
            ->paginate(10)
            ->appends(request()->query());

        return view('lphp.index', compact('lphp'));
    }

    /**
     * Daftar SBP untuk modal pemilihan SBP (dipakai dari halaman index sebelum
     * masuk ke form create, maupun dari dalam form create itu sendiri).
     */
    public function pickSbp(Request $request)
    {
        $sbpList = Sbp::with('lphp')
            ->orderBy('tanggal_sbp', 'desc')
            ->orderBy('nomor_sbp_int', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('lphp.partials.pilih-sbp-table', ['sbp' => $sbpList]);
    }

    public function create(Request $request)
    {
        if (!$request->filled('sbp_id')) {
            return redirect()->route('lphp.index')->with('error', 'Pilih SBP terlebih dahulu untuk membuat LPHP.');
        }

        $selectedSbp = Sbp::with('lphp')->find($request->query('sbp_id'));

        if (!$selectedSbp) {
            return redirect()->route('lphp.index')->with('error', 'SBP tidak ditemukan.');
        }

        if ($selectedSbp->lphp) {
            return redirect()->route('lphp.index')->with('error', 'SBP ini sudah memiliki LPHP.');
        }

        $petugasData = Petugas::orderBy('nama')->get();
        $nationalities = $this->getNationalities();

        $defaultTanggalLphp = Lphp::defaultTanggalLphp($selectedSbp);
        $previewYear = optional($defaultTanggalLphp)->year ?? date('Y');
        $previewNomorLphp = Lphp::formatNomorLphp($selectedSbp->nomor_sbp_int, $previewYear);
        $defaultDugaanPelanggaran = Lphp::inferDugaanPelanggaran($selectedSbp->jenis_barang);
        $defaultNamaTempat = Lphp::namaTempatUntuk($selectedSbp);
        $categoryDefaults = Lphp::categoryDefaults($selectedSbp);

        return view('lphp.create', compact(
            'selectedSbp',
            'petugasData',
            'nationalities',
            'previewNomorLphp',
            'defaultTanggalLphp',
            'defaultDugaanPelanggaran',
            'defaultNamaTempat',
            'categoryDefaults'
        ));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sbp_id'             => ['required', 'exists:sbp,id', Rule::unique('lphp', 'sbp_id')->whereNull('deleted_at')],
            'tanggal_lphp'        => 'required|date',
            'dugaan_pelanggaran'  => 'required|string|max:255',
            'uraian_kegiatan'     => 'required|string',
            'uraian_brg_lphp_lp'  => 'required|string',
            'nama_tempat'         => 'nullable|string|max:255',
            'pelaku_tidak_ditemukan' => 'nullable|boolean',
            'tanggal_lahir'       => 'nullable|date',
            'kewarganegaraan'     => 'nullable|string|max:255',
            'pasal'               => 'required|string|max:255',
            'uu_terkait'          => 'required|string',
            'konseptor_id'        => 'required|exists:petugas,id',
            'pengampu_id'         => 'required|exists:petugas,id',
            'pemeriksa_id'        => 'required|exists:petugas,id',
            'catatan'             => 'nullable|string',
        ]);

        $validatedData['pelaku_tidak_ditemukan'] = $request->boolean('pelaku_tidak_ditemukan');

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
        $nationalities = $this->getNationalities();
        $categoryDefaults = Lphp::categoryDefaults($lphp->sbp);

        return view('lphp.edit', compact('lphp', 'petugasData', 'nationalities', 'categoryDefaults'));
    }

    public function update(Request $request, Lphp $lphp)
    {
        $validatedData = $request->validate([
            'tanggal_lphp'        => 'required|date',
            'dugaan_pelanggaran'  => 'required|string|max:255',
            'uraian_kegiatan'     => 'required|string',
            'uraian_brg_lphp_lp'  => 'required|string',
            'nama_tempat'         => 'nullable|string|max:255',
            'pelaku_tidak_ditemukan' => 'nullable|boolean',
            'tanggal_lahir'       => 'nullable|date',
            'kewarganegaraan'     => 'nullable|string|max:255',
            'pasal'               => 'required|string|max:255',
            'uu_terkait'          => 'required|string',
            'konseptor_id'        => 'required|exists:petugas,id',
            'pengampu_id'         => 'required|exists:petugas,id',
            'pemeriksa_id'        => 'required|exists:petugas,id',
            'catatan'             => 'nullable|string',
        ]);

        $validatedData['pelaku_tidak_ditemukan'] = $request->boolean('pelaku_tidak_ditemukan');

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
