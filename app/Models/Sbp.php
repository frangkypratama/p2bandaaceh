<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\TerbilangHelper;

class Sbp extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sbp';

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
        'kota_penindakan',
        'kecamatan_penindakan',
        'flag_bast',
        'flag_ba_musnah',
        'nomor_ba_musnah',
    ];

    protected $casts = [
        'tanggal_sbp' => 'date',
        'tanggal_surat_perintah' => 'date',
        'flag_bast' => 'boolean',
        'flag_ba_musnah' => 'boolean',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($sbp) {
            if ($sbp->isForceDeleting()) {
                // Jika force delete, hapus permanen BAST juga
                $sbp->bast()->forceDelete();
            } else {
                // Jika soft delete, soft delete BAST juga
                $sbp->bast()->delete();
            }
        });

        static::restoring(function ($sbp) {
            // Saat SBP di-restore, restore juga BAST terkait
            $sbp->bast()->restore();
        });
    }

    public function petugas1()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas_1');
    }

    public function petugas2()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas_2');
    }

    public function getTanggalSbpTerbilangAttribute()
    {
        return TerbilangHelper::tanggal($this->tanggal_sbp);
    }

    public function bast()
    {
        return $this->hasOne(Bast::class);
    }
}
