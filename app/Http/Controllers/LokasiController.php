<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function getKecamatan(Request $request)
    {
        $kecamatan = [];
        if ($request->kota == 'Banda Aceh') {
            $kecamatan = ['Baiturrahman', 'Banda Raya', 'Jaya Baru', 'Kuta Alam', 'Kuta Raja', 'Lueng Bata', 'Meuraxa', 'Syiah Kuala', 'Ulee Kareng'];
        } elseif ($request->kota == 'Aceh Besar') {
            $kecamatan = ['Baitussalam', 'Blang Bintang', 'Darul Imarah', 'Darul Kamal', 'Darussalam', 'Indrapuri', 'Ingin Jaya', 'Jantho', 'Krueng Barona Jaya', 'Kuta Baro', 'Kuta Cot Glie', 'Kuta Malaka', 'Lembah Seulawah', 'Leupung', 'Lhoknga', 'Lhoong', 'Mesjid Raya', 'Montasik', 'Peukan Bada', 'Pulo Aceh', 'Seulimeum', 'Suka Makmur', 'Simpang Tiga'];
        } elseif ($request->kota == 'Pidie') {
            $kecamatan = ['Batee', 'Delima', 'Geumpang', 'Glumpang Baro', 'Glumpang Tiga', 'Grong Grong', 'Indrajaya', 'Kembang Tanjong', 'Keumala', 'Kota Sigli', 'Mane', 'Mila', 'Muara Tiga', 'Mutiara', 'Mutiara Timur', 'Padang Tiji', 'Peukan Baro', 'Pidie', 'Sakti', 'Simpang Tiga', 'Tanggse', 'Tiro', 'Geulumpang Tiga'];
        } elseif ($request->kota == 'Pidie Jaya') {
            $kecamatan = ['Bandar Baru', 'Bandar Dua', 'Jangka Buya', 'Meurah Dua', 'Meureudu', 'Panteraja', 'Trienggadeng', 'Ulim'];
        }
        return response()->json($kecamatan);
    }
}
