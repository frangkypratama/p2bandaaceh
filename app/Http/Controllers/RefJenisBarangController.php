<?php

namespace App\Http\Controllers;

use App\Models\RefJenisBarang;
use Illuminate\Http\Request;

class RefJenisBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisBarang = RefJenisBarang::orderBy('nomor_urut', 'asc')->get();
        // Mengarahkan ke view baru di root folder views
        return view('ref-jenis-barang', compact('jenisBarang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_urut' => 'required|integer|unique:ref_jenis_barang,nomor_urut',
            'nama_barang' => 'required|string|max:255',
        ]);

        RefJenisBarang::create($request->all());

        return redirect()->route('ref-jenis-barang.index')
                         ->with('success', 'Jenis barang baru berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RefJenisBarang $refJenisBarang)
    {
        $request->validate([
            'nomor_urut' => 'required|integer|unique:ref_jenis_barang,nomor_urut,' . $refJenisBarang->id,
            'nama_barang' => 'required|string|max:255',
        ]);

        $refJenisBarang->update($request->all());

        return redirect()->route('ref-jenis-barang.index')
                         ->with('success', 'Data jenis barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RefJenisBarang $refJenisBarang)
    {
        $refJenisBarang->delete();

        return redirect()->route('ref-jenis-barang.index')
                         ->with('success', 'Data jenis barang berhasil dihapus.');
    }
}
