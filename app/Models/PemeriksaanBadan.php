<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PemeriksaanBadan
 *
 * @property int $id
 * @property string $no_ba_riksa
 * @property \Illuminate\Support\Carbon $tgl_ba_riksa
 * @property string $nama
 * @property string $jenis_identitas
 * @property string $no_identitas
 * @property string $tempat_lahir
 * @property \Illuminate\Support\Carbon $tanggal_lahir
 * @property string $jenis_kelamin
 * @property string $kewarganegaraan
 * @property string $alamat_pada_identitas
 * @property string $alamat_tinggal
 * @property string $datang_dari
 * @property string $tujuan_ke
 * @property string $lokasi_pemeriksaan
 * @property string $jenis_pemeriksaan
 * @property string $hasil_pemeriksaan
 * @property string|null $rekan_perjalanan
 * @property string|null $nama_sarkut
 * @property string|null $no_register
 * @property string|null $jenis_dokumen_barang
 * @property string|null $nomor_dokumen_barang
 * @property \Illuminate\Support\Carbon|null $tgl_dokumen_barang
 * @property int $id_petugas_1
 * @property int|null $id_petugas_2
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Petugas $petugas1
 * @property-read Petugas|null $petugas2
 */
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
}
