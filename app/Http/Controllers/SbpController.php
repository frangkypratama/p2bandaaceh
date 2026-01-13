<?php

namespace App\Http\Controllers;

use App\Models\Sbp;
use Illuminate\Http\Request;

class SbpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sbpData = Sbp::latest()->paginate(10); // Ambil data terbaru, 10 per halaman
        return view('data-sbp', compact('sbpData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('input-sbp');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nomor_sbp' => 'required|unique:sbp|max:255',
            'tanggal_sbp' => 'required|date',
            'nama_pelaku' => 'required|string|max:255',
            // Tambahkan validasi lain jika perlu
        ]);

        Sbp::create($request->all());
        return redirect()->route('sbp.index')->with('success', 'Data SBP berhasil disimpan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sbp $sbp)
    {
        // Validasi input
        $request->validate([
            'nomor_sbp' => 'required|max:255|unique:sbp,nomor_sbp,' . $sbp->id,
            'tanggal_sbp' => 'required|date',
            'nama_pelaku' => 'required|string|max:255',
            // Tambahkan validasi lain jika perlu
        ]);

        $sbp->update($request->all());
        return redirect()->route('sbp.index')->with('success', 'Data SBP berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sbp $sbp)
    {
        $sbp->delete();
        return redirect()->route('sbp.index')->with('success', 'Data SBP berhasil dihapus.');
    }
}
