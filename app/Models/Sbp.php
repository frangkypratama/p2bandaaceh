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
        'nomor_ba_riksa',
        'nomor_ba_tegah',
        'nomor_ba_segel',
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
        'jenis_satuan',
        'uraian_barang',
        'nama_petugas_1',
        'nama_petugas_2',
        'id_petugas_1',
        'id_petugas_2',
        'nomor_sbp_int',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_sbp' => 'date',
        'tanggal_surat_perintah' => 'date',
    ];
}
