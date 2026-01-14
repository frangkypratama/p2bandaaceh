<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Petugas;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Petugas::create(['nama' => 'Abraham Tarigan', 'nip' => '197609291998031001']);
        Petugas::create(['nama' => 'Abizar', 'nip' => '197709281999031002']);
        Petugas::create(['nama' => 'Jefri Adrian', 'nip' => '197403022003121002']);
        Petugas::create(['nama' => 'Meiriko Sazali Saragih', 'nip' => '197905131999031002']);
        Petugas::create(['nama' => 'Rina Zenvia', 'nip' => '198509182004122002']);
        Petugas::create(['nama' => 'Tabrani', 'nip' => '198506072007011002']);
        Petugas::create(['nama' => 'Hafiz Hairullah', 'nip' => '199101122013101004']);
        Petugas::create(['nama' => 'Faisal Akbar Harahap', 'nip' => '199008082012101001']);
        Petugas::create(['nama' => 'Andrico Putra Manalu', 'nip' => '199107112012101001']);
        Petugas::create(['nama' => 'Rasyid Arfi', 'nip' => '199501132015021002']);
        Petugas::create(['nama' => 'Vitha Adhitya Nurhika Putrie', 'nip' => '199912282019122001']);
        Petugas::create(['nama' => 'Frangky Pratama Sinurat', 'nip' => '199808072018011001']);
    }
}
