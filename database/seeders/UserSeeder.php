<?php

namespace Database\Seeders;

use App\Models\Petugas;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Daftar user login: NIP (tanpa spasi) dipakai sebagai username sekaligus password awal.
     */
    public function run(): void
    {
        $adminRoleId = Role::where('name', 'admin')->value('id');
        $userRoleId = Role::where('name', 'user')->value('id');

        $users = [
            ['nama' => 'Deddy Afdhal', 'nip' => '19820605 200112 1 003', 'role_id' => $userRoleId],
            ['nama' => 'Abizar', 'nip' => '19770928 199903 1 002', 'role_id' => $userRoleId],
            ['nama' => 'Erwin', 'nip' => '19750711 199903 1 001', 'role_id' => $userRoleId],
            ['nama' => 'Sukendar', 'nip' => '19850721 200412 1 004', 'role_id' => $userRoleId],
            ['nama' => 'Rina Zenvia', 'nip' => '19850918 200412 2 002', 'role_id' => $userRoleId],
            ['nama' => 'Ivan Hermi Ardiansyah', 'nip' => '19841202 200412 1 002', 'role_id' => $userRoleId],
            ['nama' => 'Tabrani', 'nip' => '19850607 200701 1 002', 'role_id' => $userRoleId],
            ['nama' => 'Hafiz Hairullah', 'nip' => '19910112 201310 1 004', 'role_id' => $userRoleId],
            ['nama' => 'Faisal Akbar Harahap', 'nip' => '19900808 201210 1 001', 'role_id' => $userRoleId],
            ['nama' => 'Rasyid Arfi', 'nip' => '19950113 201502 1 002', 'role_id' => $userRoleId],
            // Admin default: dipakai untuk mengelola Role Management, User Management & Log Aktivitas.
            ['nama' => 'Frangky Pratama Sinurat', 'nip' => '19980807 201801 1 001', 'role_id' => $adminRoleId],
        ];

        foreach ($users as $data) {
            $nip = preg_replace('/\s+/', '', $data['nip']);

            // Tautkan ke data petugas jika NIP-nya cocok. Tidak semua user
            // login punya padanan di tabel petugas, dan itu tidak masalah.
            $petugas = Petugas::where('nip', $nip)->first();

            User::updateOrCreate(
                ['nip' => $nip],
                [
                    'name' => $data['nama'],
                    'password' => $nip,
                    'role_id' => $data['role_id'],
                    'petugas_id' => $petugas?->id,
                ]
            );
        }
    }
}
