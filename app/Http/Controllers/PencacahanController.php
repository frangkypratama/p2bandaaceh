<?php

namespace App\Http\Controllers;

use App\Models\DetailPencacahan;
use App\Models\Pencacahan;
use App\Models\PencacahanPhoto;
use App\Models\Petugas;
use App\Models\RefJenisBarang;
use App\Models\RefSatuan;
use App\Models\RefTarifCukai;
use App\Models\Sbp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

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
            'lokasi_cacah' => 'nullable|string|max:255',
            'id_petugas_1' => 'required|exists:petugas,id',
            'id_petugas_2' => 'nullable|exists:petugas,id|different:id_petugas_1',
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
            $pencacahan->sbp()->attach($validatedData['id_sbp']);

            foreach ($validatedData['id_sbp'] as $sbpId) {
                $pencacahanSbp = DB::table('pencacahan_sbp')
                    ->where('pencacahan_id', $pencacahan->id)
                    ->where('sbp_id', $sbpId)
                    ->first();
                
                if (!$pencacahanSbp) continue;

                if (isset($request->detail_barang_json[$sbpId])) {
                    $detailBarangArray = json_decode($request->detail_barang_json[$sbpId], true);
                    if (is_array($detailBarangArray)) {
                        foreach ($detailBarangArray as $item) {
                            $item['pencacahan_sbp_id'] = $pencacahanSbp->id;
                            DetailPencacahan::create($item);
                        }
                    }
                }

                if ($request->hasFile("foto_barang.$sbpId")) {
                    $file = $request->file("foto_barang.$sbpId");
                    $filename = $file->getClientOriginalName();
                    $path = $file->store('public/pencacahan_photos');

                    PencacahanPhoto::create([
                        'pencacahan_sbp_id' => $pencacahanSbp->id,
                        'path' => $path,
                        'filename' => $filename,
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
        $pencacahan = Pencacahan::with('petugas1', 'petugas2', 'sbp')->findOrFail($id);
        return view('pencacahan.show', compact('pencacahan'));
    }

    public function edit(string $id)
    {
        $pencacahan = Pencacahan::with('sbp')->findOrFail($id);
        $petugasData = Petugas::all();
        $satuanData = RefSatuan::all();
        $jenisBarangData = RefJenisBarang::get();
        $tarifCukaiData = RefTarifCukai::all();
        $sbpDataForView = $pencacahan->sbp;
        if (old('id_sbp')) {
             $sbpDataForView = Sbp::whereIn('id', old('id_sbp'))->get();
        }
        return view('pencacahan.edit', compact('pencacahan', 'petugasData', 'sbpDataForView', 'satuanData', 'jenisBarangData', 'tarifCukaiData'));
    }

    public function update(Request $request, string $id)
    {
        $pencacahan = Pencacahan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'no_ba_cacah' => ['required', 'string', 'max:255', Rule::unique('pencacahan')->ignore($pencacahan->id)],
            'tanggal_ba_cacah' => 'required|date',
            'lokasi_cacah' => 'nullable|string|max:255',
            'id_petugas_1' => 'required|exists:petugas,id',
            'id_petugas_2' => 'nullable|exists:petugas,id|different:id_petugas_1',
            'id_sbp' => 'required|array|min:1',
            'id_sbp.*' => 'required|exists:sbp,id',
            'detail_barang_json' => 'nullable|array',
            'detail_barang_json.*' => 'nullable|json',
            'foto_barang' => 'nullable|array',
            'foto_barang.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'foto_barang.*.image' => 'File yang diunggah harus berupa gambar.',
            'foto_barang.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'foto_barang.*.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('pencacahan.edit', $id)->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        DB::beginTransaction();
        try {
            $pencacahan->update($validatedData);
            $pencacahan->sbp()->sync($validatedData['id_sbp']);

            $pencacahanSbps = DB::table('pencacahan_sbp')->where('pencacahan_id', $pencacahan->id)->get();

            foreach ($pencacahanSbps as $pencacahanSbp) {
                DetailPencacahan::where('pencacahan_sbp_id', $pencacahanSbp->id)->delete();
                $oldPhotos = PencacahanPhoto::where('pencacahan_sbp_id', $pencacahanSbp->id)->get();
                foreach ($oldPhotos as $photo) {
                    Storage::delete($photo->path);
                    $photo->delete();
                }

                if (isset($request->detail_barang_json[$pencacahanSbp->sbp_id])) {
                    $detailBarangArray = json_decode($request->detail_barang_json[$pencacahanSbp->sbp_id], true);
                    if (is_array($detailBarangArray)) {
                        foreach ($detailBarangArray as $item) {
                            $item['pencacahan_sbp_id'] = $pencacahanSbp->id;
                            DetailPencacahan::create($item);
                        }
                    }
                }

                if ($request->hasFile("foto_barang.{$pencacahanSbp->sbp_id}")) {
                    $file = $request->file("foto_barang.{$pencacahanSbp->sbp_id}");
                    $filename = $file->getClientOriginalName();
                    $path = $file->store('public/pencacahan_photos');

                    PencacahanPhoto::create([
                        'pencacahan_sbp_id' => $pencacahanSbp->id,
                        'path' => $path,
                        'filename' => $filename,
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
        $pencacahan = Pencacahan::findOrFail($id);
        $pencacahan->sbp()->detach();
        $pencacahan->delete();
        return redirect()->route('pencacahan.index')->with('success', 'Data Pencacahan berhasil dihapus.');
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

        $sbp = $query->paginate(5)->appends(['search' => $search]);

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
        $data = $request->input('data', []);
        $nama_barang = $jenisBarang->nama_barang;

        return view($viewName, compact('satuanData', 'tarifCukaiData', 'data', 'nama_barang'))->render();
    }
}
