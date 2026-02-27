<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\TerbilangHelper;

class PemeriksaanBadan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pemeriksaan_badan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_ba_riksa',
        'tgl_ba_riksa',
        'no_surat_perintah',
        'tgl_surat_perintah',
        'nama',
        'jenis_identitas',
        'no_identitas',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'kewarganegaraan',
        'alamat_pada_identitas',
        'alamat_tinggal',
        'datang_dari',
        'tujuan_ke',
        'lokasi_pemeriksaan',
        'jenis_pemeriksaan',
        'hasil_pemeriksaan',
        'rekan_perjalanan',
        'nama_sarkut',
        'no_register',
        'jenis_dokumen_barang',
        'nomor_dokumen_barang',
        'tgl_dokumen_barang',
        'id_petugas_1',
        'id_petugas_2',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tgl_ba_riksa' => 'datetime',
        'tgl_surat_perintah' => 'datetime',
        'tanggal_lahir' => 'datetime',
        'tgl_dokumen_barang' => 'datetime',
    ];

    /**
     * Get the first officer for the examination.
     */
    public function petugas1()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas_1');
    }

    /**
     * Get the second officer for the examination.
     */
    public function petugas2()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas_2');
    }

    /**
     * Get the full examination date in a worded format.
     *
     * @return string
     */
    public function getTanggalBaRiksaTerbilangAttribute()
    {
        if ($this->tgl_ba_riksa) {
            return TerbilangHelper::tanggal($this->tgl_ba_riksa);
        }
        return 'Pada hari - tanggal - bulan - tahun -';
    }
}
