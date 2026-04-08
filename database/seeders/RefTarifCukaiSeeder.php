<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RefTarifCukai;

class RefTarifCukaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RefTarifCukai::insert([
            // 1. SKM
            [
                'jenis' => 'SKM',
                'golongan' => 'I',
                'hje_min' => 2375,
                'hje_max' => null,
                'tarif' => 1231,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'SKM',
                'golongan' => 'II',
                'hje_min' => 1485,
                'hje_max' => null,
                'tarif' => 746,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 2. SPM
            [
                'jenis' => 'SPM',
                'golongan' => 'I',
                'hje_min' => 2495,
                'hje_max' => null,
                'tarif' => 1336,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'SPM',
                'golongan' => 'II',
                'hje_min' => 1565,
                'hje_max' => null,
                'tarif' => 794,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 3. SKT
            [
                'jenis' => 'SKT',
                'golongan' => 'I',
                'hje_min' => 2170,
                'hje_max' => null,
                'tarif' => 483,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'SKT',
                'golongan' => 'I',
                'hje_min' => 1555,
                'hje_max' => 2170,
                'tarif' => 378,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'SKT',
                'golongan' => 'II',
                'hje_min' => 995,
                'hje_max' => null,
                'tarif' => 223,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'SKT',
                'golongan' => 'III',
                'hje_min' => 860,
                'hje_max' => null,
                'tarif' => 122,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // 4. SPT
            [
                'jenis' => 'SPT',
                'golongan' => 'I',
                'hje_min' => 2170,
                'hje_max' => null,
                'tarif' => 483,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'SPT',
                'golongan' => 'I',
                'hje_min' => 1555,
                'hje_max' => 2170,
                'tarif' => 378,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'SPT',
                'golongan' => 'II',
                'hje_min' => 995,
                'hje_max' => null,
                'tarif' => 223,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'SPT',
                'golongan' => 'III',
                'hje_min' => 860,
                'hje_max' => null,
                'tarif' => 122,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 5. SKTF
            [
                'jenis' => 'SKTF',
                'golongan' => 'Tanpa Golongan',
                'hje_min' => 2375,
                'hje_max' => null,
                'tarif' => 1231,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 6. SPTF
            [
                'jenis' => 'SPTF',
                'golongan' => 'Tanpa Golongan',
                'hje_min' => 2375,
                'hje_max' => null,
                'tarif' => 1231,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 7. KLM
            [
                'jenis' => 'KLM',
                'golongan' => 'I',
                'hje_min' => 950,
                'hje_max' => null,
                'tarif' => 483,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'KLM',
                'golongan' => 'II',
                'hje_min' => 275,
                'hje_max' => null, 
                'tarif' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'jenis' => 'KLM',
                'golongan' => 'II',
                'hje_min' => 200,
                'hje_max' => 275,
                'tarif' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 8. TIS
            [
                'jenis' => 'TIS',
                'golongan' => 'Tanpa Golongan',
                'hje_min' => 180,
                'hje_max' => 275,
                'tarif' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'TIS',
                'golongan' => 'Tanpa Golongan',
                'hje_min' => 55,
                'hje_max' => 180,
                'tarif' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 9. KLB
            [
                'jenis' => 'KLB',
                'golongan' => 'Tanpa Golongan',
                'hje_min' => 290,
                'hje_max' => null,
                'tarif' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 10. CRT
            [
                'jenis' => 'CRT',
                'golongan' => 'Tanpa Golongan',
                'hje_min' => 198000,
                'hje_max' => null,
                'tarif' => 110000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'CRT',
                'golongan' => 'Tanpa Golongan',
                'hje_min' => 55000,
                'hje_max' => 198000,
                'tarif' => 22000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'CRT',
                'golongan' => 'Tanpa Golongan',
                'hje_min' => 22000,
                'hje_max' => 55000,
                'tarif' => 11000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'CRT',
                'golongan' => 'Tanpa Golongan',
                'hje_min' => 5500,
                'hje_max' => 22000,
                'tarif' => 1320,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'CRT',
                'golongan' => 'Tanpa Golongan',
                'hje_min' => 495,
                'hje_max' => 5500,
                'tarif' => 275,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
