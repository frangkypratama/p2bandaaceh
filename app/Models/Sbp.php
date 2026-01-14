<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sbp extends Model
{
    use HasFactory;

    protected $table = 'sbp';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nomor_sbp',
        'tanggal_sbp',
        'nomor_surat_perintah',
        'tanggal_surat_perintah',
        'nama_pelaku',
        'jenis_identitas',
        'nomor_identitas',
        'lokasi_penindakan',
        'waktu_penindakan',
        'alasan_penindakan',
        'jenis_barang',
        'jumlah_barang',
        'uraian_barang',
        'nama_petugas_1',
        'nama_petugas_2',
    ];
}
