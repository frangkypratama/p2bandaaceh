<?php

namespace App\Http\Controllers;

use App\Models\RefJenisBarang;
use App\Models\RefSatuan;
use Illuminate\Http\Request;

class RefJenisBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the 'satuan' relationship and get all data
        $jenisBarang = RefJenisBarang::with('satuan')->orderBy('id', 'asc')->get();
        
        // Get all 'satuan' for the modal form
        $satuans = RefSatuan::orderBy('nama_satuan', 'asc')->get();

        // Pass both datasets to the view
        return view('ref-jenis-barang', compact('jenisBarang', 'satuans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'id_satuan_default' => 'required|exists:ref_satuan,id'
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
            'nama_barang' => 'required|string|max:255',
            'id_satuan_default' => 'required|exists:ref_satuan,id'
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
