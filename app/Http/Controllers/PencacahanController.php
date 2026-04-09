<?php

namespace App\Http\Controllers;

use App\Models\Pencacahan;
use App\Models\Petugas;
use App\Models\RefJenisBarang;
use App\Models\RefSatuan;
use App\Models\RefTarifCukai;
use App\Models\Sbp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        ]);

        if ($validator->fails()) {
            $request->flash();
            return redirect()->route('pencacahan.create')->withErrors($validator);
        }

        $validatedData = $validator->validated();
        $pencacahan = Pencacahan::create($validatedData);
        $pencacahan->sbp()->attach($validatedData['id_sbp']);

        return redirect()->route('pencacahan.index')->with('success', 'Data Pencacahan berhasil ditambahkan.');
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
        ]);

        if ($validator->fails()) {
            $request->flash();
            return redirect()->route('pencacahan.edit', $id)->withErrors($validator);
        }

        $pencacahan->update($validator->validated());
        $pencacahan->sbp()->sync($request->id_sbp);
        return redirect()->route('pencacahan.index')->with('success', 'Data Pencacahan berhasil diperbarui.');
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
}
