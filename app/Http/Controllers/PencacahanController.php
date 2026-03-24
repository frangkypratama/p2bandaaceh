<?php

namespace App\Http\Controllers;

use App\Models\Pencacahan;
use App\Models\Petugas;
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
        $oldSbpData = [];

        if (old('id_sbp')) {
            $oldSbpData = Sbp::whereIn('id', old('id_sbp'))->get();
        }

        return view('pencacahan.create', compact('petugasData', 'oldSbpData'));
    }

    public function store(Request $request)
    {
        // Validasi tetap sama
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

    // ... (Fungsi show, edit, update, destroy tetap sama seperti sebelumnya)
    public function show(string $id)
    {
        $pencacahan = Pencacahan::with('petugas1', 'petugas2', 'sbp')->findOrFail($id);
        return view('pencacahan.show', compact('pencacahan'));
    }

    public function edit(string $id)
    {
        $pencacahan = Pencacahan::with('sbp')->findOrFail($id);
        $petugasData = Petugas::all();
        $sbpDataForView = $pencacahan->sbp;
        if (old('id_sbp')) {
             $sbpDataForView = Sbp::whereIn('id', old('id_sbp'))->get();
        }
        return view('pencacahan.edit', compact('pencacahan', 'petugasData', 'sbpDataForView'));
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

    /**
     * Fungsi ini menangani pencarian SBP via AJAX.
     * Fungsi ini sekarang mengembalikan JSON yang bersih dan terstruktur.
     */
    public function searchSbp(Request $request)
    {
        $search = $request->input('search', '');
        $query = Sbp::latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_sbp', 'like', "%{$search}%")
                  ->orWhere('nama_pelaku', 'like', "%{$search}%"); // Mencari di kolom nama_pelaku
            });
        }

        $sbp_results = $query->limit(20)->get();

        // Format ulang hasil untuk kebutuhan AJAX di frontend
        $formatted_sbp = $sbp_results->map(function($item) {
            return [
                'id' => $item->id,
                'nomor_sbp' => $item->nomor_sbp,
                'tanggal_sbp' => $item->tanggal_sbp->toDateString(), // Kirim sebagai string Y-m-d
                'nama_pelaku' => $item->nama_pelaku, // Langsung dari kolom
                'jenis_barang' => $item->jenis_barang,
                'kondisi_barang' => $item->kondisi_barang,
                'uraian_barang' => $item->uraian_barang,
            ];
        });

        return response()->json($formatted_sbp);
    }
}
