<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\TerbilangHelper;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'no_hp',
        'jenis_kelamin',
        'alamat_di_indonesia',
        'kondisi_barang',
    ];

    protected $casts = [
        'tanggal_sbp' => 'date',
        'tanggal_surat_perintah' => 'date',
        'flag_bast' => 'boolean',
        'flag_ba_musnah' => 'boolean',
    ];

    /**
     * Kolom internal (bukan mass-assignable) yang menyimpan nomor_sbp hanya untuk baris
     * aktif dan dilindungi unique index di database. Lihat migration
     * add_nomor_sbp_active_unique_to_sbp_table.
     */
    protected $hidden = [
        'nomor_sbp_active',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($sbp) {
            // Sinkron otomatis di setiap create/update/restore (semuanya lewat save()).
            $sbp->nomor_sbp_active = $sbp->trashed() ? null : $sbp->nomor_sbp;
        });

        static::deleting(function ($sbp) {
            if ($sbp->isForceDeleting()) {
                // Jika force delete, hapus permanen BAST juga
                $sbp->bast()->forceDelete();
            } else {
                // Jika soft delete, soft delete BAST juga
                $sbp->bast()->delete();

                // Soft delete menulis deleted_at lewat query langsung (bukan save()),
                // jadi hook 'saving' di atas tidak ikut jalan. Kosongkan manual supaya
                // nomor_sbp ini bisa dipakai lagi oleh SBP baru.
                $sbp->forceFill(['nomor_sbp_active' => null])->saveQuietly();
            }
        });

        static::restoring(function ($sbp) {
            // Saat SBP di-restore, restore juga BAST terkait
            $sbp->bast()->restore();
        });
    }

    public function petugas1()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas_1')->withTrashed();
    }

    public function petugas2()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas_2')->withTrashed();
    }

    public function getTanggalSbpTerbilangAttribute()
    {
        return TerbilangHelper::tanggal($this->tanggal_sbp);
    }

    public function bast()
    {
        return $this->hasOne(Bast::class);
    }

    public function pencacahan(): BelongsToMany
    {
        return $this->belongsToMany(Pencacahan::class, 'pencacahan_sbp', 'sbp_id', 'pencacahan_id');
    }

    public function lpt()
    {
        return $this->hasOne(Lpt::class);
    }

    /**
     * Format nomor SBP dari nomor urut dan tahun, mis. "SBP-12/KBC.0102/2025".
     */
    public static function formatNomorSbp(int $nomorSbpInt, int $tahun): string
    {
        return "SBP-{$nomorSbpInt}/KBC.0102/{$tahun}";
    }

    /**
     * Bangun set nomor (SBP, BA Riksa, BA Tegah, BA Segel) dari nomor urut dan tahun yang sama.
     */
    public static function buildNomorSet(int $nomorSbpInt, int $tahun): array
    {
        return [
            'nomor_sbp' => self::formatNomorSbp($nomorSbpInt, $tahun),
            'nomor_ba_riksa' => "BA-{$nomorSbpInt}/RIKSA/KBC.010202/{$tahun}",
            'nomor_ba_tegah' => "BA-{$nomorSbpInt}/TEGAH/KBC.010202/{$tahun}",
            'nomor_ba_segel' => "BA-{$nomorSbpInt}/SEGEL/KBC.010202/{$tahun}",
        ];
    }
}
