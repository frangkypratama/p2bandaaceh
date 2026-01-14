<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $petugasData = Petugas::paginate(10);
        return view('data-petugas', compact('petugasData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|unique:petugas',
        ]);

        Petugas::create($request->all());

        return redirect()->route('petugas.index')
                        ->with('success', 'Data petugas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Petugas $petugas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Petugas $petugas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Petugas $petugas)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|unique:petugas,nip,'.$petugas->id,
        ]);

        $petugas->update($request->all());

        return redirect()->route('petugas.index')
                        ->with('success', 'Data petugas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Petugas $petugas)
    {
        $petugas->delete();

        return redirect()->route('petugas.index')
                        ->with('success', 'Data petugas berhasil dihapus.');
    }
}
