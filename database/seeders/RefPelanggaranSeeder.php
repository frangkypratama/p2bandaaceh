<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RefPelanggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Kosongkan tabel sebelum mengisi data baru
        DB::table('ref_pelanggaran')->truncate();

        DB::table('ref_pelanggaran')->insert([
            [
                'pelanggaran' => 'Membawa Barang yang diduga termasuk Barang Larangan dan Pembatasan yang Tidak Diberitahukan pada Dokumen BC2.2 (Customs Declaration) berdasarkan Pasal 53 Undang-Undang Nomor 17 Tahun 2006 tentang perubahan Undang-Undang Nomor 10 Tahun 1995 tentang Kepabeanan dan Permendag Nomor 16 Tahun 2025',
                'created_at' => $now, 
                'updated_at' => $now
            ],
            [
                'pelanggaran' => 'Membawa Barang yang diduga melebihi Batas Pembebasan Cukai Barang Bawaan Penumpang berdasarkan Undang-Undang Nomor 39 Tahun 2007 tentang Perubahan Atas Undang-Undang Nomor 11 Tahun 1995 tentang Cukai dan PMK-203/PMK.04/2017 tentang tentang Ketentuan Ekspor Dan Impor Barang Yang Dibawa Oleh Penumpang Dan Awak Sarana Pengangkut',
                'created_at' => $now, 
                'updated_at' => $now
            ],
            [
                'pelanggaran' => 'Membawa Barang yang diduga termasuk Barang Larangan dan Pembatasan yang Tidak Diberitahukan pada Dokumen BC2.2 (Customs Declaration) berdasarkan Pasal 53 Undang-Undang Nomor 17 Tahun 2006 tentang perubahan Undang-Undang Nomor 10 Tahun 1995 tentang Kepabeanan dan Peraturan Badan Pengawas Obat dan Makanan No. 28 Tahun 2023',
                'created_at' => $now, 
                'updated_at' => $now
            ],
            [
                'pelanggaran' => 'Membawa Barang yang diduga termasuk Barang Larangan dan Pembatasan yang Tidak Diberitahukan pada Dokumen BC2.2 (Customs Declaration) berdasarkan Pasal 53 Undang-Undang Nomor 17 Tahun 2006 tentang perubahan Undang-Undang Nomor 10 Tahun 1995 tentang Kepabeanan dan Peraturan Badan Karantina No. 5 tahun 2024 tentang Tindakan Karantina Terhadap Barang Bawaan',
                'created_at' => $now, 
                'updated_at' => $now
            ],
        ]);
    }
}
