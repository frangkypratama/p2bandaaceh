<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\PangkatGolongan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $petugasData = Petugas::orderBy('nama', 'asc')->paginate(10);
        $pangkatGolonganData = PangkatGolongan::orderBy('golongan', 'asc')->get();
        return view('data-petugas', compact('petugasData', 'pangkatGolonganData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $buatUser = $request->boolean('buat_user');

        $nipRules = [
            'required',
            'string',
            'max:20',
            Rule::unique('petugas')->whereNull('deleted_at'),
        ];

        // Kalau sekalian dibuatkan akun login, NIP juga harus unik di tabel users.
        if ($buatUser) {
            $nipRules[] = Rule::unique('users', 'nip');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => $nipRules,
            'pangkat_golongan_id' => 'nullable|exists:pangkat_golongan,id',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $pangkatGolongan = PangkatGolongan::find($request->pangkat_golongan_id);

        $petugas = Petugas::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'pangkat' => $pangkatGolongan ? $pangkatGolongan->pangkat : null,
            'golongan' => $pangkatGolongan ? $pangkatGolongan->golongan : null,
            'jabatan' => $request->jabatan,
        ]);

        if ($buatUser) {
            User::create([
                'name' => $petugas->nama,
                'nip' => $petugas->nip,
                'petugas_id' => $petugas->id,
                'password' => $petugas->nip,
            ]);
        }

        $message = 'Data petugas berhasil ditambahkan.'
            . ($buatUser ? ' Akun login (NIP sebagai username & password) juga berhasil dibuat.' : '');

        return redirect()->back()->with('success', $message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Petugas $petugas)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => [
                'required',
                'string',
                'max:20',
                Rule::unique('petugas')->ignore($petugas->id)->whereNull('deleted_at'),
            ],
            'pangkat_golongan_id' => 'nullable|exists:pangkat_golongan,id',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $pangkatGolongan = PangkatGolongan::find($request->pangkat_golongan_id);

        $petugas->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'pangkat' => $pangkatGolongan ? $pangkatGolongan->pangkat : null,
            'golongan' => $pangkatGolongan ? $pangkatGolongan->golongan : null,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->back()->with('success', 'Data petugas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Petugas $petugas)
    {
        $petugas->delete();

        return redirect()->back()->with('success', 'Data petugas berhasil dihapus.');
    }
}
