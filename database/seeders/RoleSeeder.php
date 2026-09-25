<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * 'admin' = akses penuh (is_admin, bypass matrix permission).
     * 'user'  = role default; diberi SEMUA permission supaya user yang sudah ada
     *           tidak mendadak kehilangan akses saat fitur role ini diaktifkan.
     *           Admin bisa mempersempit lewat halaman Role Management, atau
     *           membuat role baru yang lebih terbatas.
     */
    public function run(): void
    {
        $admin = Role::updateOrCreate(
            ['name' => 'admin'],
            ['label' => 'Admin', 'is_admin' => true]
        );

        $user = Role::updateOrCreate(
            ['name' => 'user'],
            ['label' => 'User', 'is_admin' => false]
        );

        $user->permissions()->sync(Permission::pluck('id'));
        $admin->permissions()->sync([]);
    }
}
