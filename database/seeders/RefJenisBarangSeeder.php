<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RefJenisBarang;

class RefJenisBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisBarang = [
            [1, 'Tekstil & Produk Tekstil & Accessories'],
            [2, 'Ballpress'],
            [3, 'Daging (Sapi/Ayam/Babi/Bebek)'],
            [4, 'Beras'],
            [5, 'Gula'],
            [6, 'Bawang'],
            [7, 'Serealia'],
            [8, 'Sembako Lainya'],
            [9, 'Handphone, Gadget, Part & Accesories'],
            [10, 'Elektronik'],
            [11, 'Biji & Produk Plastik (Kec. Furniture)'],
            [12, 'Besi, Baja & Produknya (Kec. Furniture)'],
            [13, 'Kendaraan Darat (Bermotor/Tidak), Part & Accessories'],
            [14, 'Kendaraan Air (Bermotor/Tidak), Part & Accessories'],
            [15, 'Kendaraan Udara (Bermotor/Tidak), Part & Accessories'],
            [16, 'Makanan Dan Minuman (Olahan / Kemasan)'],
            [17, 'Produk Pertanian & Perkebunan'],
            [18, 'Logam Mulia Dan Perhiasan'],
            [19, 'Logam Non Mulia'],
            [20, 'Senjata Api, Airgun, Airsoftgun & Part'],
            [21, 'Bahan Peledak & Ammonium Nitrat'],
            [22, 'Senjata Tajam'],
            [23, 'Kosmetik'],
            [24, 'Obat-Obatan'],
            [25, 'Bahan Kimia'],
            [26, 'Cites (Flora & Fauna)'],
            [27, 'Hewan Dan Bagian Tubuh (Non Cites)'],
            [28, 'Tumbuhan Dan Bagian Tumbuhan (Non Cites)'],
            [29, 'Benda Cagar Budaya'],
            [30, 'Produk Melanggar Haki'],
            [31, 'Kayu & Rotan (Asalan)'],
            [32, 'Produk Olahan Kayu & Rotan (Kec. Furniture)'],
            [33, 'Furniture'],
            [34, 'Pupuk'],
            [35, 'Racun & Pestisida'],
            [36, 'Crude Oil (Minyak Mentah), Pelumas & Bbm'],
            [37, 'Uang Tunai /Bni'],
            [38, 'Hasil Tembakau'],
            [39, 'Minuman Mengandung Etil Alkohol'],
            [40, 'Etil Alkohol'],
            [41, 'Pita Cukai'],
            [42, 'Crude Palm Oil (Minyak Sawit)'],
            [43, 'Produk Turunan Cpo (Kec. Minyak Goreng)'],
            [44, 'Minerba, Tanah, Pasir & Top Soil'],
            [45, 'Barang Pornografi & Sextoys'],
            [46, 'Alat Berat, Part & Acc'],
            [47, 'Mesin (Bakar, Listrik, Pompa, Dll)'],
            [48, 'Produk Perikanan & Kelautan'],
            [49, 'Produk Mainan & Alat Olah Raga'],
            [50, 'Alat Kesehatan'],
            [51, 'Perkakas (Mekanik/Elektrik)'],
            [52, 'Peralatan Dapur Dan Kamar Mandi'],
            [53, 'Bibit Dan Benih Tanaman'],
            [54, 'Alas Kaki'],
            [55, 'Tas'],
            [56, 'Limbah & Scrap'],
            [57, 'HVG (High Value Goods)'],
            [58, 'Persyaratan Perizinan'],
            [59, 'Pembukuan, Pencatatan, & Administrasi Lainnya'],
            [60, 'Barang Lainnya'],
            [61, 'Barang & Bahan Radioaktif']
        ];

        foreach ($jenisBarang as $barang) {
            RefJenisBarang::create([
                'nomor_urut' => $barang[0],
                'nama_barang' => $barang[1]
            ]);
        }
    }
}
