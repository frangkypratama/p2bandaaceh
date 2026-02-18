<?php

namespace App\Http\Controllers;

use App\Models\SuratPerintah;
use Illuminate\Http\Request;

class SuratPerintahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suratPerintah = SuratPerintah::latest()->paginate(10);
        return view('surat-perintah.index', compact('suratPerintah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_prin' => 'required|string|max:255|unique:surat_perintah',
            'tanggal_prin' => 'required|date',
        ]);

        SuratPerintah::create($request->all());

        return redirect()->route('surat-perintah.index')
            ->with('success', 'Surat Perintah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratPerintah $suratPerintah)
    {
        return view('surat-perintah.show', compact('suratPerintah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratPerintah $suratPerintah)
    {
        $request->validate([
            'nomor_prin' => 'required|string|max:255|unique:surat_perintah,nomor_prin,' . $suratPerintah->id,
            'tanggal_prin' => 'required|date',
        ]);

        $suratPerintah->update($request->all());

        return redirect()->route('surat-perintah.index')
            ->with('success', 'Surat Perintah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratPerintah $suratPerintah)
    {
        $suratPerintah->delete();

        return redirect()->route('surat-perintah.index')
            ->with('success', 'Surat Perintah berhasil dihapus.');
    }
}
