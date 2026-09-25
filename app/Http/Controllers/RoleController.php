<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::withCount('users')->with('permissions')->orderBy('label')->get();
        $permissions = Permission::orderBy('group')->orderBy('label')->get()->groupBy('group');

        return view('role-management.index', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $baseSlug = (string) str($request->label)->slug();
        $name = $baseSlug;
        $suffix = 2;
        while (Role::where('name', $name)->exists()) {
            $name = $baseSlug.'-'.$suffix++;
        }

        $role = Role::create([
            'name' => $name,
            'label' => $request->label,
            'is_admin' => false, // role admin hanya lewat seeder, tidak lewat form ini
        ]);

        $role->permissions()->sync($request->input('permissions', []));

        return redirect()->route('role-management.index')->with('success', 'Role berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Role admin (is_admin) aksesnya selalu penuh di luar matrix,
        // jadi tidak perlu (dan tidak boleh) diatur permission-nya lewat sini.
        if (! $role->is_admin) {
            $role->permissions()->sync($request->input('permissions', []));
        }

        $role->update([
            'label' => $request->label,
        ]);

        return redirect()->route('role-management.index')->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->is_admin) {
            return redirect()->route('role-management.index')->with('error', 'Role admin tidak bisa dihapus.');
        }

        if ($role->users()->exists()) {
            return redirect()->route('role-management.index')->with('error', 'Role ini masih dipakai oleh user, tidak bisa dihapus.');
        }

        $role->delete();

        return redirect()->route('role-management.index')->with('success', 'Role berhasil dihapus.');
    }
}
