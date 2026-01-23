<?php

namespace App\Http\Controllers;

use App\Models\RefPelanggaran;
use Illuminate\Http\Request;

class RefPelanggaranController extends Controller
{
    public function index()
    {
        $pelanggaran = RefPelanggaran::all();
        return view('ref_pelanggaran', compact('pelanggaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_pelanggaran' => 'required|string|unique:ref_pelanggaran,pelanggaran',
        ]);

        RefPelanggaran::create($request->all());

        return redirect()->route('ref-pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pelanggaran_edit = RefPelanggaran::findOrFail($id);
        $pelanggaran = RefPelanggaran::all();
        return view('ref_pelanggaran', compact('pelanggaran_edit', 'pelanggaran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_pelanggaran' => 'required|string|max:255|unique:ref_pelanggaran,pelanggaran,' . $id,
        ]);

        $pelanggaran = RefPelanggaran::findOrFail($id);
        $pelanggaran->update($request->all());

        return redirect()->route('ref-pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pelanggaran = RefPelanggaran::findOrFail($id);
        $pelanggaran->delete();

        return redirect()->route('ref-pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil dihapus.');
    }
}
