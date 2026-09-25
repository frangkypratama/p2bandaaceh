<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Halaman profil milik user yang sedang login (bukan untuk mengelola user lain).
     */
    public function edit(Request $request)
    {
        $user = $request->user()->load('petugas');

        return view('profile.edit', compact('user'));
    }

    /**
     * Update nama sendiri. NIP (username) sengaja tidak bisa diubah lewat sini
     * karena itu identitas login yang dikelola lewat User Management.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $request->user()->update([
            'name' => $request->name,
        ]);

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Ubah password sendiri. Wajib memasukkan password saat ini sebagai verifikasi.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'current_password.current_password' => 'Password saat ini yang Anda masukkan salah.',
        ]);

        $request->user()->update([
            'password' => $request->password,
        ]);

        return redirect()->route('profile.edit')->with('success', 'Password berhasil diubah.');
    }
}
