<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanBadan;
use App\Models\Petugas;
use App\Models\SuratPerintah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Helpers\TerbilangHelper;

class PemeriksaanBadanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemeriksaanBadan = PemeriksaanBadan::with('petugas1', 'petugas2')->paginate(10);
        return view('pemeriksaan-badan.index', compact('pemeriksaanBadan'));
    }

    /**
     * Returns a collection of nationalities for the dropdown.
     *
     * @return \Illuminate\Support\Collection
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $petugasData = Petugas::all();
        $nationalities = $this->getNationalities();
        $suratPerintahData = SuratPerintah::all();
        return view('pemeriksaan-badan.create', compact('petugasData', 'nationalities', 'suratPerintahData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_ba_riksa' => 'required|string|max:255|unique:pemeriksaan_badan,no_ba_riksa',
            'tgl_ba_riksa' => 'required|date',
            'no_surat_perintah' => 'nullable|string|max:255',
            'tgl_surat_perintah' => 'nullable|date',
            'nama' => 'required|string|max:255',
            'jenis_identitas' => 'required|string|max:255',
            'no_identitas' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:255',
            'kewarganegaraan' => 'required|string|max:255',
            'alamat_pada_identitas' => 'required|string',
            'alamat_tinggal' => 'required|string',
            'datang_dari' => 'required|string|max:255',
            'tujuan_ke' => 'required|string|max:255',
            'lokasi_pemeriksaan' => 'required|string|max:255',
            'jenis_pemeriksaan' => 'required|string|max:255',
            'hasil_pemeriksaan' => 'required|string',
            'rekan_perjalanan' => 'nullable|string|max:255',
            'nama_sarkut' => 'nullable|string|max:255',
            'no_register' => 'nullable|string|max:255',
            'jenis_dokumen_barang' => 'nullable|string|max:255',
            'nomor_dokumen_barang' => 'nullable|string|max:255',
            'tgl_dokumen_barang' => 'nullable|date',
            'id_petugas_1' => 'required|exists:petugas,id',
            'id_petugas_2' => 'nullable|exists:petugas,id',
        ]);

        PemeriksaanBadan::create($validatedData);

        return redirect()->route('pemeriksaan-badan.index')
                        ->with('success', 'Data Pemeriksaan Badan berhasil ditambahkan.');
    }

    /**
     * Get the last BA Riksa number and return the next number.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLastNumber()
    {
        try {
            $currentYear = now()->year;

            $lastPemeriksaan = PemeriksaanBadan::whereYear('tgl_ba_riksa', $currentYear)
                ->orderBy('id', 'desc')
                ->first();

            if ($lastPemeriksaan && preg_match('/^BA-(\d+)/', $lastPemeriksaan->no_ba_riksa, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            } else {
                $nextNumber = 1;
            }

            return response()->json(['next_number' => $nextNumber]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not retrieve the last number.'], 500);
        }
    }

    /**
     * Generate PDF for the specified resource and stream it to the browser.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cetak($id)
    {
        $pemeriksaanBadan = PemeriksaanBadan::with('petugas1', 'petugas2')->findOrFail($id);
        
        Carbon::setLocale('id');
        $tanggal_ba_riksa = Carbon::parse($pemeriksaanBadan->tgl_ba_riksa);
        $hari = TerbilangHelper::terbilang($tanggal_ba_riksa->day);
        $bulan = $tanggal_ba_riksa->getTranslatedMonthName();
        $tahun = TerbilangHelper::terbilang($tanggal_ba_riksa->year);
        $tanggal_ba_riksa_terbilang = ucwords($hari) . ' ' . ucwords($bulan) . ' ' . ucwords($tahun);
        
        $filename = str_replace('/', '-', $pemeriksaanBadan->no_ba_riksa) . '.pdf';

        $pdf = Pdf::loadView('templatecetak.template-ba-riksa-badan', compact('pemeriksaanBadan', 'tanggal_ba_riksa_terbilang'))
                  ->setPaper([0, 0, 609.45, 935.43], 'portrait');

        return $pdf->stream($filename);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pemeriksaanBadan = PemeriksaanBadan::findOrFail($id);
        $petugasData = Petugas::all();
        $nationalities = $this->getNationalities();
        $suratPerintahData = SuratPerintah::all();
        return view('pemeriksaan-badan.edit', compact('pemeriksaanBadan', 'petugasData', 'nationalities', 'suratPerintahData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pemeriksaanBadan = PemeriksaanBadan::findOrFail($id);

        $validatedData = $request->validate([
            'no_ba_riksa' => [
                'required',
                'string',
                'max:255',
                Rule::unique('pemeriksaan_badan')->ignore($pemeriksaanBadan->id),
            ],
            'tgl_ba_riksa' => 'required|date',
            'no_surat_perintah' => 'nullable|string|max:255',
            'tgl_surat_perintah' => 'nullable|date',
            'nama' => 'required|string|max:255',
            'jenis_identitas' => 'required|string|max:255',
            'no_identitas' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:255',
            'kewarganegaraan' => 'required|string|max:255',
            'alamat_pada_identitas' => 'required|string',
            'alamat_tinggal' => 'required|string',
            'datang_dari' => 'required|string|max:255',
            'tujuan_ke' => 'required|string|max:255',
            'lokasi_pemeriksaan' => 'required|string|max:255',
            'jenis_pemeriksaan' => 'required|string|max:255',
            'hasil_pemeriksaan' => 'required|string',
            'rekan_perjalanan' => 'nullable|string|max:255',
            'nama_sarkut' => 'nullable|string|max:255',
            'no_register' => 'nullable|string|max:255',
            'jenis_dokumen_barang' => 'nullable|string|max:255',
            'nomor_dokumen_barang' => 'nullable|string|max:255',
            'tgl_dokumen_barang' => 'nullable|date',
            'id_petugas_1' => 'required|exists:petugas,id',
            'id_petugas_2' => 'nullable|exists:petugas,id',
        ]);

        $pemeriksaanBadan->update($validatedData);

        return redirect()->route('pemeriksaan-badan.index')
                        ->with('success', 'Data Pemeriksaan Badan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pemeriksaanBadan = PemeriksaanBadan::findOrFail($id);
        $pemeriksaanBadan->delete();

        return redirect()->route('pemeriksaan-badan.index')
                        ->with('success', 'Data Pemeriksaan Badan berhasil dihapus.');
    }
}
