<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateJenisBarangSatuanDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Fetch all satuan and create a lookup map
        $satuanLookup = DB::table('ref_satuan')->pluck('id', 'nama_satuan');

        // 2. Define a more logical mapping from item name to unit name
        $barangToSatuanMap = [
            'Tekstil & Produk Tekstil & Accessories' => 'Pcs',
            'Ballpress' => 'Unit',
            'Daging (Sapi/Ayam/Babi/Bebek)' => 'Kilogram',
            'Beras' => 'Kilogram',
            'Gula' => 'Kilogram',
            'Bawang' => 'Kilogram',
            'Serealia' => 'Kilogram',
            'Sembako Lainya' => 'Pcs',
            'Handphone, Gadget, Part & Accesories' => 'Unit',
            'Elektronik' => 'Unit',
            'Biji & Produk Plastik (Kec. Furniture)' => 'Kilogram',
            'Besi, Baja & Produknya (Kec. Furniture)' => 'Kilogram',
            'Kendaraan Darat (Bermotor/Tidak), Part & Accessories' => 'Unit',
            'Kendaraan Air (Bermotor/Tidak), Part & Accessories' => 'Unit',
            'Kendaraan Udara (Bermotor/Tidak), Part & Accessories' => 'Unit',
            'Makanan Dan Minuman (Olahan / Kemasan)' => 'Bungkus',
            'Produk Pertanian & Perkebunan' => 'Kilogram',
            'Logam Mulia Dan Perhiasan' => 'Gram',
            'Logam Non Mulia' => 'Kilogram',
            'Senjata Api, Airgun, Airsoftgun & Part' => 'Unit',
            'Bahan Peledak & Ammonium Nitrat' => 'Kilogram',
            'Senjata Tajam' => 'Buah',
            'Kosmetik' => 'Pcs',
            'Obat-Obatan' => 'Pcs',
            'Bahan Kimia' => 'Liter',
            'Cites (Flora & Fauna)' => 'Buah',
            'Hewan Dan Bagian Tubuh (Non Cites)' => 'Buah',
            'Tumbuhan Dan Bagian Tumbuhan (Non Cites)' => 'Buah',
            'Benda Cagar Budaya' => 'Unit',
            'Produk Melanggar Haki' => 'Unit',
            'Kayu & Rotan (Asalan)' => 'Batang',
            'Produk Olahan Kayu & Rotan (Kec. Furniture)' => 'Unit',
            'Furniture' => 'Set',
            'Pupuk' => 'Kilogram',
            'Racun & Pestisida' => 'Liter',
            'Crude Oil (Minyak Mentah), Pelumas & Bbm' => 'Liter',
            'Uang Tunai /Bni' => 'Unit',
            'Hasil Tembakau' => 'Kilogram',
            'Minuman Mengandung Etil Alkohol' => 'Botol',
            'Etil Alkohol' => 'Liter',
            'Pita Cukai' => 'Pcs',
            'Crude Palm Oil (Minyak Sawit)' => 'Kilogram',
            'Produk Turunan Cpo (Kec. Minyak Goreng)' => 'Liter',
            'Minerba, Tanah, Pasir & Top Soil' => 'Kilogram',
            'Barang Pornografi & Sextoys' => 'Pcs',
            'Alat Berat, Part & Acc' => 'Unit',
            'Mesin (Bakar, Listrik, Pompa, Dll)' => 'Unit',
            'Produk Perikanan & Kelautan' => 'Kilogram',
            'Produk Mainan & Alat Olah Raga' => 'Pcs',
            'Alat Kesehatan' => 'Unit',
            'Perkakas (Mekanik/Elektrik)' => 'Set',
            'Peralatan Dapur Dan Kamar Mandi' => 'Set',
            'Bibit Dan Benih Tanaman' => 'Kilogram',
            'Alas Kaki' => 'Pasang',
            'Tas' => 'Buah',
            'Limbah & Scrap' => 'Kilogram',
            'HVG (High Value Goods)' => 'Unit',
            'Persyaratan Perizinan' => 'Unit',
            'Pembukuan, Pencatatan, & Administrasi Lainnya' => 'Unit',
            'Barang Lainnya' => 'Unit',
            'Barang & Bahan Radioaktif' => 'Gram',
        ];

        // 3. Loop through the map and update the database
        foreach ($barangToSatuanMap as $namaBarang => $namaSatuan) {
            if (isset($satuanLookup[$namaSatuan])) {
                $idSatuan = $satuanLookup[$namaSatuan];
                DB::table('ref_jenis_barang')
                    ->where('nama_barang', $namaBarang)
                    ->update(['id_satuan_default' => $idSatuan]);
            }
        }
    }
}
