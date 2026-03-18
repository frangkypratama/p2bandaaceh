<?php

namespace App\Http\Controllers;

use App\Models\Pencacahan;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PencacahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pencacahan = Pencacahan::with('petugas1', 'petugas2')->paginate(10);
        return view('pencacahan.index', compact('pencacahan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $petugasData = Petugas::all();
        return view('pencacahan.create', compact('petugasData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_ba_cacah' => 'required|string|max:255|unique:pencacahan,no_ba_cacah',
            'tanggal_ba_cacah' => 'required|date',
            'lokasi_cacah' => 'nullable|string|max:255',
            'id_petugas_1' => 'required|exists:petugas,id',
            'id_petugas_2' => 'nullable|exists:petugas,id',
        ]);

        Pencacahan::create($validatedData);

        return redirect()->route('pencacahan.index')
                        ->with('success', 'Data Pencacahan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pencacahan = Pencacahan::findOrFail($id);
        $petugasData = Petugas::all();
        return view('pencacahan.edit', compact('pencacahan', 'petugasData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pencacahan = Pencacahan::findOrFail($id);

        $validatedData = $request->validate([
            'no_ba_cacah' => [
                'required',
                'string',
                'max:255',
                Rule::unique('pencacahan')->ignore($pencacahan->id),
            ],
            'tanggal_ba_cacah' => 'required|date',
            'lokasi_cacah' => 'nullable|string|max:255',
            'id_petugas_1' => 'required|exists:petugas,id',
            'id_petugas_2' => 'nullable|exists:petugas,id',
        ]);

        $pencacahan->update($validatedData);

        return redirect()->route('pencacahan.index')
                        ->with('success', 'Data Pencacahan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pencacahan = Pencacahan::findOrFail($id);
        $pencacahan->delete();

        return redirect()->route('pencacahan.index')
                        ->with('success', 'Data Pencacahan berhasil dihapus.');
    }
}
