<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Daftar permission = daftar modul/menu yang bisa diatur lewat Role Management.
     * Key harus sama persis dengan yang dipakai middleware 'permission:<key>' di routes/web.php.
     */
    public function run(): void
    {
        $permissions = [
            ['key' => 'pemeriksaan-badan', 'label' => 'Pemeriksaan Badan', 'group' => 'Pemeriksaan'],
            ['key' => 'sbp', 'label' => 'Input & Data SBP', 'group' => 'Penindakan'],
            ['key' => 'lpt', 'label' => 'Data LPT', 'group' => 'Penindakan'],
            ['key' => 'pencacahan', 'label' => 'Berita Acara Pencacahan', 'group' => 'Pencacahan'],
            ['key' => 'lphp', 'label' => 'LPHP', 'group' => 'Penelitian Penindakan'],
            ['key' => 'lp', 'label' => 'Laporan Pelanggaran', 'group' => 'Penelitian Penindakan'],
            ['key' => 'lpp', 'label' => 'LPP', 'group' => 'Penelitian Perkara'],
            ['key' => 'lpf', 'label' => 'LPF', 'group' => 'Penelitian Perkara'],
            ['key' => 'split', 'label' => 'SPLIT', 'group' => 'Penelitian Perkara'],
            ['key' => 'lhp', 'label' => 'LHP', 'group' => 'Penelitian Perkara'],
            ['key' => 'petugas', 'label' => 'Data Petugas', 'group' => 'Referensi'],
            ['key' => 'ref-pelanggaran', 'label' => 'Referensi Pelanggaran', 'group' => 'Referensi'],
            ['key' => 'ref-satuan', 'label' => 'Referensi Satuan', 'group' => 'Referensi'],
            ['key' => 'ref-jenis-barang', 'label' => 'Referensi Jenis Barang', 'group' => 'Referensi'],
            ['key' => 'surat-perintah', 'label' => 'Referensi Surat Perintah', 'group' => 'Referensi'],
            ['key' => 'ref-tarif-cukai', 'label' => 'Referensi Tarif Cukai', 'group' => 'Referensi'],
            ['key' => 'bast', 'label' => 'BAST', 'group' => 'Referensi'],
            ['key' => 'bariksa-badan', 'label' => 'Bariksa Badan', 'group' => 'Referensi'],
            ['key' => 'database', 'label' => 'Database Explorer', 'group' => 'System'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['key' => $permission['key']], $permission);
        }
    }
}
