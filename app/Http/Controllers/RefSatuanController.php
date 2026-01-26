<?php

namespace App\Http\Controllers;

use App\Models\RefSatuan;
use Illuminate\Http\Request;

class RefSatuanController extends Controller
{
    public function index()
    {
        $satuan = RefSatuan::all();
        return view('ref-satuan', compact('satuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|unique:ref_satuan,nama_satuan',
        ]);

        RefSatuan::create($request->all());

        return redirect()->route('ref-satuan.index')
            ->with('success', 'Data satuan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $satuan_edit = RefSatuan::findOrFail($id);
        $satuan = RefSatuan::all();
        return view('ref-satuan', compact('satuan_edit', 'satuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_satuan' => 'required|string|unique:ref_satuan,nama_satuan,' . $id,
        ]);

        $satuan = RefSatuan::findOrFail($id);
        $satuan->update($request->all());

        return redirect()->route('ref-satuan.index')
            ->with('success', 'Data satuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $satuan = RefSatuan::findOrFail($id);
        $satuan->delete();

        return redirect()->route('ref-satuan.index')
            ->with('success', 'Data satuan berhasil dihapus.');
    }
}
