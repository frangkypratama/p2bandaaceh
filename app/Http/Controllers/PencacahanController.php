<?php

namespace App\Http\Controllers;

use App\Models\DetailPencacahan;
use App\Models\Pencacahan;
use App\Models\PencacahanPhoto;
use App\Models\PencacahanSbp;
use App\Models\Petugas;
use App\Models\RefJenisBarang;
use App\Models\RefSatuan;
use App\Models\RefTarifCukai;
use App\Models\Sbp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use setasign\Fpdi\Fpdi;

class PencacahanController extends Controller
{
    public function index()
    {
        $pencacahan = Pencacahan::with('petugas1', 'petugas2', 'sbp')->latest()->paginate(10);
        return view('pencacahan.index', compact('pencacahan'));
    }

    public function create()
    {
        $petugasData = Petugas::all();
        $satuanData = RefSatuan::all();
        $jenisBarangData = RefJenisBarang::get();
        $tarifCukaiData = RefTarifCukai::all();
        $oldSbpData = [];

        if (old('id_sbp')) {
            $oldSbpData = Sbp::whereIn('id', old('id_sbp'))->get();
        }

        return view('pencacahan.create', compact('petugasData', 'oldSbpData', 'satuanData', 'jenisBarangData', 'tarifCukaiData'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_ba_cacah' => 'required|string|max:255|unique:pencacahan,no_ba_cacah',
            'tanggal_ba_cacah' => 'required|date',
            'no_surat_tugas_pencacahan' => 'nullable|string|max:255',
            'tanggal_surat_tugas_pencacahan' => 'nullable|date',
            'lokasi_cacah' => 'nullable|string|max:255',
            'id_petugas_1' => 'required|exists:petugas,id',
            'id_petugas_2' => 'nullable|exists:petugas,id|different:id_petugas_1',
            'giat' => 'nullable|string|max:255',
            'id_sbp' => 'required|array|min:1',
            'id_sbp.*' => 'required|exists:sbp,id',
            'detail_barang_json' => 'nullable|array',
            'detail_barang_json.*' => 'nullable|json',
            'foto_barang' => 'nullable|array',
            'foto_barang.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ], [
            'foto_barang.*.image' => 'File yang diunggah harus berupa gambar.',
            'foto_barang.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'foto_barang.*.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('pencacahan.create')->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        DB::beginTransaction();
        try {
            $pencacahan = Pencacahan::create($validatedData);
            $pencacahan->sbp()->sync($validatedData['id_sbp']);

            $PencacahanSbp = PencacahanSbp::where('pencacahan_id', $pencacahan->id)->get()->keyBy('sbp_id');
            $fillableAttributes = (new DetailPencacahan())->getFillable();

            foreach ($validatedData['id_sbp'] as $sbpId) {
                $pencacahanSbp = $PencacahanSbp->get($sbpId);
                if (!$pencacahanSbp) continue;

                if (isset($request->detail_barang_json[$sbpId])) {
                    $detailBarangArray = json_decode($request->detail_barang_json[$sbpId], true);
                    if (is_array($detailBarangArray)) {
                        $detailsToCreate = array_map(function ($item) use ($pencacahanSbp, $fillableAttributes) {
                            $filteredItem = array_intersect_key($item, array_flip($fillableAttributes));
                            $filteredItem['pencacahan_sbp_id'] = $pencacahanSbp->id;
                            return $filteredItem;
                        }, $detailBarangArray);
                        
                        $detailsToCreate = array_filter($detailsToCreate);
                        if(!empty($detailsToCreate)){
                            foreach ($detailsToCreate as $detail) {
                                DetailPencacahan::create($detail);
                            }
                        }
                    }
                }

                if ($request->hasFile("foto_barang.$sbpId")) {
                    $file = $request->file("foto_barang.$sbpId");
                    $folder = 'pencacahan_photos';
                    $path = $file->store($folder, 'public');
                    PencacahanPhoto::create([
                        'pencacahan_sbp_id' => $pencacahanSbp->id,
                        'path' => $path,
                        'filename' => $file->hashName(),
                    ]);
                }
            }
            
            DB::commit();
            return redirect()->route('pencacahan.index')->with('success', 'Data Pencacahan berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pencacahan.create')->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }


    public function show(string $id)
    {
        $pencacahan = Pencacahan::with('petugas1', 'petugas2', 'sbp', 'details', 'photos')->findOrFail($id);
        return view('pencacahan.show', compact('pencacahan'));
    }

    public function edit(string $id)
    {
        $pencacahan = Pencacahan::with('sbp')->findOrFail($id);
        $petugasData = Petugas::all();
        $satuanData = RefSatuan::all();
        $jenisBarangData = RefJenisBarang::get();
        $tarifCukaiData = RefTarifCukai::all();
        
        $sbpDataForView = $pencacahan->sbp()->withPivot('id')->get();
        
        if (old('id_sbp')) {
             $sbpDataForView = Sbp::whereIn('id', old('id_sbp'))->get();
        } else {
            $pencacahanSbpIds = $sbpDataForView->pluck('pivot.id');
            $existingDetails = DetailPencacahan::whereIn('pencacahan_sbp_id', $pencacahanSbpIds)->get()->groupBy('pencacahan_sbp_id');
            $existingPhotos = PencacahanPhoto::whereIn('pencacahan_sbp_id', $pencacahanSbpIds)->get()->keyBy('pencacahan_sbp_id');

            $sbpDataForView->each(function($sbp) use ($existingDetails, $existingPhotos) {
                $pivotId = $sbp->pivot->id;
                $sbp->details_json = $existingDetails->get($pivotId) ? $existingDetails->get($pivotId)->toJson() : '[]';
                $sbp->has_file = $existingPhotos->has($pivotId) ? '1' : '0';
            });
        }

        return view('pencacahan.edit', compact('pencacahan', 'petugasData', 'sbpDataForView', 'satuanData', 'jenisBarangData', 'tarifCukaiData'));
    }


    public function update(Request $request, string $id)
    {
        $pencacahan = Pencacahan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'no_ba_cacah' => ['required', 'string', 'max:255', Rule::unique('pencacahan')->ignore($pencacahan->id)],
            'tanggal_ba_cacah' => 'required|date',
            'no_surat_tugas_pencacahan' => 'nullable|string|max:255',
            'tanggal_surat_tugas_pencacahan' => 'nullable|date',
            'lokasi_cacah' => 'nullable|string|max:255',
            'id_petugas_1' => 'required|exists:petugas,id',
            'id_petugas_2' => 'nullable|exists:petugas,id|different:id_petugas_1',
            'giat' => 'nullable|string|max:255',
            'id_sbp' => 'required|array|min:1',
            'id_sbp.*' => 'required|exists:sbp,id',
            'detail_barang_json' => 'nullable|array',
            'detail_barang_json.*' => 'nullable|json',
            'foto_barang' => 'nullable|array',
            'foto_barang.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'deleted_photos' => 'nullable|array', // To handle photo deletion
        ]);

        if ($validator->fails()) {
            return redirect()->route('pencacahan.edit', $id)->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        DB::beginTransaction();
        try {
            $pencacahan->update($validatedData);
            $pencacahan->sbp()->sync($validatedData['id_sbp']);

            $PencacahanSbp = PencacahanSbp::where('pencacahan_id', $pencacahan->id)->get()->keyBy('sbp_id');
            $fillableAttributes = (new DetailPencacahan())->getFillable();

            foreach ($PencacahanSbp as $sbpId => $pencacahanSbp) {
                $pencacahanSbp->details()->delete();
                
                $existingPhoto = $pencacahanSbp->photos()->first();
                if ($existingPhoto) {
                    Storage::disk('public')->delete($existingPhoto->path);
                    $existingPhoto->delete();
                }

                if (isset($request->detail_barang_json[$sbpId])) {
                    $detailBarangArray = json_decode($request->detail_barang_json[$sbpId], true);
                    if (is_array($detailBarangArray)) {
                         $detailsToCreate = array_map(function ($item) use ($pencacahanSbp, $fillableAttributes) {
                            $filteredItem = array_intersect_key($item, array_flip($fillableAttributes));
                            $filteredItem['pencacahan_sbp_id'] = $pencacahanSbp->id;
                            return $filteredItem;
                        }, $detailBarangArray);
                        
                        $detailsToCreate = array_filter($detailsToCreate);
                        if(!empty($detailsToCreate)){
                            foreach ($detailsToCreate as $detail) {
                                DetailPencacahan::create($detail);
                            }
                        }
                    }
                }

                if ($request->hasFile("foto_barang.$sbpId")) {
                    $file = $request->file("foto_barang.$sbpId");
                    $folder = 'pencacahan_photos';
                    $path = $file->store($folder, 'public');
                    PencacahanPhoto::create([
                        'pencacahan_sbp_id' => $pencacahanSbp->id,
                        'path' => $path,
                        'filename' => $file->hashName(),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pencacahan.index')->with('success', 'Data Pencacahan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pencacahan.edit', $id)->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $pencacahan = Pencacahan::findOrFail($id);

            // Hapus record dari tabel pivot
            PencacahanSbp::where('pencacahan_id', $pencacahan->id)->delete();

            // Hapus record utama
            $pencacahan->delete();

            DB::commit();

            return redirect()->route('pencacahan.index')->with('success', 'Data Pencacahan berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pencacahan.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
    
    public function searchSbp(Request $request)
    {
        $search = $request->input('search', '');
        $query = Sbp::withExists('pencacahan')->latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_sbp', 'like', "%{$search}%")
                  ->orWhere('nama_pelaku', 'like', "%{$search}%");
            });
        }

        $sbp = $query->paginate(10)->appends(['search' => $search]);

        if ($request->ajax()) {
            return response()->json([
                'data' => $sbp->items(),
                'pagination' => $sbp->links()->toHtml(),
            ]);
        }

        return response()->json($sbp);
    }

    public function getBarangFields(Request $request)
    {
        $jenisBarang = RefJenisBarang::find($request->input('id_jenis_barang'));
        if (!$jenisBarang) {
            return response('<div class="text-center text-muted p-3">Pilih jenis barang yang valid.</div>', 400);
        }

        $conditionalViews = [
            'Hasil Tembakau',
            'Handphone, Gadget, Part & Accesories',
            'Elektronik',
            'Kendaraan Darat (Bermotor/Tidak), Part & Accessories',
            'Kendaraan Air (Bermotor/Tidak), Part & Accessories',
            'Kendaraan Udara (Bermotor/Tidak), Part & Accessories',
            'Minuman Mengandung Etil Alkohol',
            'Etil Alkohol',
            'Pita Cukai',
            'Narkotika, Psikotropika, dan Prekursor',
            'Senjata Api, Airgun, Airsoftgun & Part',
            'Uang Tunai /Bni',
            'CITES (Flora & Fauna)',
            'Logam Mulia Dan Perhiasan',
            'Crude Oil (Minyak Mentah), Pelumas & BBM',
            'Crude Palm Oil (Minyak Sawit)',
            'Produk Turunan CPO (Kec. Minyak Goreng)',
            'Bahan Kimia',
            'Barang & Bahan Radioaktif',
            'Hewan Dan Bagian Tubuh (Non Cites)',
            'Tumbuhan Dan Bagian Tumbuhan (Non Cites)',
            'Benda Cagar Budaya',
            'Kayu & Rotan (Asalan)',
            'Produk Melanggar Haki',
            'Alat Kesehatan',
            'Kosmetik',
            'Obat-Obatan',
            'Kayu Olahan'
        ];

        $viewName = in_array($jenisBarang->nama_barang, $conditionalViews)
            ? 'pencacahan.partials.fields._conditional'
            : 'pencacahan.partials.fields._default';

        $satuanData = RefSatuan::all();
        $tarifCukaiData = RefTarifCukai::all();
        $data = json_decode($request->input('data', '{}'), true);
        $nama_barang = $jenisBarang->nama_barang;

        return view($viewName, compact('satuanData', 'tarifCukaiData', 'data', 'nama_barang'))->render();
    }

    public function cetak(string $id)
    {
        $pencacahan = Pencacahan::with([
            'petugas1',
            'petugas2',
            'sbp' => function ($query) {
                $query->withPivot('id');
            },
            'details' => function ($query) {
                $query->with(['jenisBarang', 'satuan']);
            },
            'photos'
        ])->findOrFail($id);

        Carbon::setLocale('id');
        $filename = 'BA-CACAH-' . str_replace('/', '-', $pencacahan->no_ba_cacah) . '.pdf';
        $tempPath = storage_path('app/temp');
        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0777, true);
        }

        // 1. Buat PDF Potret & simpan
        $pdfPotret = Pdf::loadView('templatecetak.template-ba-cacah', compact('pencacahan'));
        $potretPath = $tempPath . '/' . uniqid('potret_') . '.pdf';
        $pdfPotret->save($potretPath);

        // 2. Buat PDF Lanskap & simpan
        $pdfLanskap = Pdf::loadView('templatecetak.template-ba-cacah-lampiran', compact('pencacahan'));
        $lanskapPath = $tempPath . '/' . uniqid('lanskap_') . '.pdf';
        $pdfLanskap->save($lanskapPath);

        // 3. Gabungkan dengan FPDI dalam urutan yang benar
        $fpdi = new Fpdi();

        // Ambil Halaman 1 (Berita Acara) dari PDF Potret
        $pageCountPotret = $fpdi->setSourceFile($potretPath);
        $templateId = $fpdi->importPage(1);
        $size = $fpdi->getTemplateSize($templateId);
        $fpdi->AddPage($size['orientation'], $size);
        $fpdi->useTemplate($templateId);

        // Ambil semua halaman dari PDF Lanskap (Lampiran)
        $pageCountLanskap = $fpdi->setSourceFile($lanskapPath);
        for ($pageNo = 1; $pageNo <= $pageCountLanskap; $pageNo++) {
            $templateId = $fpdi->importPage($pageNo);
            $size = $fpdi->getTemplateSize($templateId);
            $fpdi->AddPage($size['orientation'], $size);
            $fpdi->useTemplate($templateId);
        }

        // Jika ada halaman kedua di PDF Potret (Foto), tambahkan di akhir
        if ($pageCountPotret > 1) {
            $fpdi->setSourceFile($potretPath); // Set ulang source file ke potret
            for ($pageNo = 2; $pageNo <= $pageCountPotret; $pageNo++) {
                $templateId = $fpdi->importPage($pageNo);
                $size = $fpdi->getTemplateSize($templateId);
                $fpdi->AddPage($size['orientation'], $size);
                $fpdi->useTemplate($templateId);
            }
        }

        // 4. Kirim output & hapus file sementara
        try {
            $output = $fpdi->Output('S', $filename);
            unlink($potretPath);
            unlink($lanskapPath);
            return response($output, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]);
        } catch (\Exception $e) {
            if (file_exists($potretPath)) unlink($potretPath);
            if (file_exists($lanskapPath)) unlink($lanskapPath);
            throw $e;
        }
    }
}
