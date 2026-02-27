<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanBadan;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;

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
            "Afghan", "Albanian", "Algerian", "American", "Andorran", "Angolan", "Argentinian", "Armenian", "Australian", "Austrian", "Azerbaijani",
            "Bahamian", "Bahraini", "Bangladeshi", "Barbadian", "Belarusian", "Belgian", "Belizean", "Beninese", "Bhutanese", "Bolivian", "Bosnian", "Botswanan", "Brazilian", "British", "Bruneian", "Bulgarian", "Burkinabe", "Burundian",
            "Cambodian", "Cameroonian", "Canadian", "Cape Verdean", "Chadian", "Chilean", "Chinese", "Colombian", "Comoran", "Congolese", "Costa Rican", "Croatian", "Cuban", "Cypriot", "Czech",
            "Danish", "Djiboutian", "Dominican",
            "Ecuadorean", "Egyptian", "Eritrean", "Estonian", "Ethiopian",
            "Fijian", "Finnish", "French",
            "Gabonese", "Gambian", "Georgian", "German", "Ghanaian", "Greek", "Grenadian", "Guatemalan", "Guinean",
            "Haitian", "Honduran", "Hungarian",
            "Icelandic", "Indian", "Indonesian", "Iranian", "Iraqi", "Irish", "Israeli", "Italian",
            "Jamaican", "Japanese", "Jordanian",
            "Kazakhstani", "Kenyan", "Kuwaiti", "Kyrgyz",
            "Laotian", "Latvian", "Lebanese", "Liberian", "Libyan", "Liechtensteiner", "Lithuanian", "Luxembourger",
            "Macedonian", "Malagasy", "Malawian", "Malaysian", "Maldivan", "Malian", "Maltese", "Mauritanian", "Mauritian", "Mexican", "Moldovan", "Monacan", "Mongolian", "Montenegrin", "Moroccan", "Mozambican",
            "Namibian", "Nepalese", "Dutch", "New Zealander", "Nicaraguan", "Nigerian", "North Korean", "Norwegian",
            "Omani",
            "Pakistani", "Panamanian", "Paraguayan", "Peruvian", "Filipino", "Polish", "Portuguese",
            "Qatari",
            "Romanian", "Russian", "Rwandan",
            "Saudi Arabian", "Senegalese", "Serbian", "Singaporean", "Slovak", "Slovenian", "Somali", "South African", "South Korean", "Spanish", "Sri Lankan", "Sudanese", "Swedish", "Swiss", "Syrian",
            "Taiwanese", "Tajik", "Tanzanian", "Thai", "Togolese", "Tongan", "Tunisian", "Turkish", "Turkmen",
            "Ugandan", "Ukrainian", "Emirati", "Uruguayan", "Uzbek",
            "Venezuelan", "Vietnamese",
            "Yemeni",
            "Zambian", "Zimbabwean"
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
        return view('pemeriksaan-badan.create', compact('petugasData', 'nationalities'));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pemeriksaanBadan = PemeriksaanBadan::with('petugas1', 'petugas2')->findOrFail($id);
        return view('pemeriksaan-badan.show', compact('pemeriksaanBadan'));
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
        return view('pemeriksaan-badan.edit', compact('pemeriksaanBadan', 'petugasData', 'nationalities'));
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
