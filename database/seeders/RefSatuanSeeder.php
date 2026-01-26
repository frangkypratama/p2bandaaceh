<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefSatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $satuan = [
            ['nama_satuan' => 'Pcs'],
            ['nama_satuan' => 'Pkg'],
            ['nama_satuan' => 'Unit'],
            ['nama_satuan' => 'Batang'],
            ['nama_satuan' => 'Botol'],
            ['nama_satuan' => 'Gram'],
            ['nama_satuan' => 'Kilogram'],
            ['nama_satuan' => 'Buah'],
            ['nama_satuan' => 'Bungkus'],
            ['nama_satuan' => 'Kotak'],
            ['nama_satuan' => 'Liter'],
            ['nama_satuan' => 'Mililiter'],
            ['nama_satuan' => 'Karton'],
            ['nama_satuan' => 'Set'],
            ['nama_satuan' => 'Pasang'],
        ];

        // Insert data into the ref_satuan table, ignoring duplicates
        foreach ($satuan as $item) {
            DB::table('ref_satuan')->updateOrInsert($item);
        }
    }
}
