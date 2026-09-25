<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userData = User::with(['petugas', 'role'])->orderBy('name', 'asc')->paginate(10);

        // Hanya petugas yang belum punya akun yang ditawarkan saat menambah user baru.
        $petugasOptions = Petugas::whereDoesntHave('user')->orderBy('nama', 'asc')->get();
        $roles = Role::orderBy('label')->get();
        $defaultRoleId = Role::where('name', 'user')->value('id');

        return view('user-management.index', compact('userData', 'petugasOptions', 'roles', 'defaultRoleId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => ['required', 'string', 'max:20', Rule::unique('users', 'nip')],
            'role_id' => ['required', Rule::exists('roles', 'id')],
            'petugas_id' => [
                'nullable',
                Rule::exists('petugas', 'id')->whereNull('deleted_at'),
                Rule::unique('users', 'petugas_id'),
            ],
        ]);

        User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'role_id' => $request->role_id,
            'petugas_id' => $request->petugas_id ?: null,
            'password' => $request->nip, // password awal = NIP
        ]);

        return redirect()->route('user-management.index')->with('success', 'Akun user berhasil ditambahkan. NIP dipakai sebagai username & password.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => ['required', 'string', 'max:20', Rule::unique('users', 'nip')->ignore($user->id)],
            'role_id' => ['required', Rule::exists('roles', 'id')],
            'petugas_id' => [
                'nullable',
                Rule::exists('petugas', 'id')->whereNull('deleted_at'),
                Rule::unique('users', 'petugas_id')->ignore($user->id),
            ],
        ]);

        // Admin tidak boleh menurunkan role akunnya sendiri, supaya tidak terkunci
        // dari halaman Role Management / User Management / Log Aktivitas.
        if ($user->id === $request->user()->id) {
            $newRole = Role::find($request->role_id);
            if (! $newRole || ! $newRole->is_admin) {
                return redirect()->route('user-management.index')->with('error', 'Anda tidak bisa menurunkan role akun Anda sendiri.');
            }
        }

        $user->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'role_id' => $request->role_id,
            'petugas_id' => $request->petugas_id ?: null,
        ]);

        return redirect()->route('user-management.index')->with('success', 'Akun user berhasil diperbarui.');
    }

    /**
     * Reset password akun kembali ke NIP.
     */
    public function resetPassword(User $user)
    {
        $user->update(['password' => $user->nip]);

        return redirect()->route('user-management.index')->with('success', 'Password '.$user->name.' berhasil direset ke NIP.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return redirect()->route('user-management.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('user-management.index')->with('success', 'Akun user berhasil dihapus.');
    }
}
