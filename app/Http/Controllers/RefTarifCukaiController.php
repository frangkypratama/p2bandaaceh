<?php

namespace App\Http\Controllers;

use App\Models\RefTarifCukai;
use Illuminate\Http\Request;

class RefTarifCukaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarifCukai = RefTarifCukai::all();
        return view('ref-tarif-cukai', compact('tarifCukai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string|max:255',
            'golongan' => 'required|string|max:255',
            'hje_min' => 'required|numeric',
            'hje_max' => 'nullable|numeric',
            'tarif' => 'required|numeric',
        ]);

        RefTarifCukai::create($request->all());

        return redirect()->route('ref-tarif-cukai.index')
            ->with('success', 'Referensi tarif cukai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not used
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jenis' => 'required|string|max:255',
            'golongan' => 'required|string|max:255',
            'hje_min' => 'required|numeric',
            'hje_max' => 'nullable|numeric',
            'tarif' => 'required|numeric',
        ]);

        $tarifCukai = RefTarifCukai::findOrFail($id);
        $tarifCukai->update($request->all());

        return redirect()->route('ref-tarif-cukai.index')
            ->with('success', 'Referensi tarif cukai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tarifCukai = RefTarifCukai::findOrFail($id);
        $tarifCukai->delete();

        return redirect()->route('ref-tarif-cukai.index')
            ->with('success', 'Referensi tarif cukai berhasil dihapus.');
    }
}
