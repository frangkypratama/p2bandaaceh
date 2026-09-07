<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lphp extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lphp';

    protected $fillable = [
        'sbp_id',
        'nomor_lphp',
        'tanggal_lphp',
        'dugaan_pelanggaran',
        'nama_tempat',
        'pasal',
        'uu_terkait',
        'konseptor_id',
        'pengampu_id',
        'pemeriksa_id',
        'catatan',
    ];

    protected $casts = [
        'tanggal_lphp' => 'date',
    ];

    /**
     * Kolom internal (bukan mass-assignable) yang menyimpan sbp_id hanya untuk baris
     * aktif dan dilindungi unique index di database. Lihat migration create_lphp_table.
     */
    protected $hidden = [
        'sbp_id_active',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::saving(function ($lphp) {
            $lphp->sbp_id_active = $lphp->trashed() ? null : $lphp->sbp_id;
        });

        static::deleting(function ($lphp) {
            if ($lphp->isForceDeleting()) {
                // instance ->forceDelete() (bukan relasi) supaya event model Lp ikut terpicu.
                optional($lphp->lp)->forceDelete();
            } else {
                // instance ->delete() (bukan relasi) supaya event model Lp ikut terpicu -
                // relasi ->delete() hanya bulk update ke DB dan tidak memicu event model,
                // sehingga hook 'saving' milik Lp (mengosongkan lphp_id_active) tidak jalan.
                optional($lphp->lp)->delete();

                $lphp->forceFill(['sbp_id_active' => null])->saveQuietly();
            }
        });

        static::restoring(function ($lphp) {
            // Ambil instance Lp yang trashed lalu restore lewat instance supaya event model jalan.
            optional($lphp->lp()->withTrashed()->first())->restore();
        });
    }

    public function sbp()
    {
        return $this->belongsTo(Sbp::class);
    }

    public function lp()
    {
        return $this->hasOne(Lp::class);
    }

    public function konseptor()
    {
        return $this->belongsTo(Petugas::class, 'konseptor_id')->withTrashed();
    }

    public function pengampu()
    {
        return $this->belongsTo(Petugas::class, 'pengampu_id')->withTrashed();
    }

    public function pemeriksa()
    {
        return $this->belongsTo(Petugas::class, 'pemeriksa_id')->withTrashed();
    }

    /**
     * Format nomor LPHP. Nomor urut mengikuti nomor SBP asalnya,
     * mis. "LPHP-101/KBC.010202/2026".
     */
    public static function formatNomorLphp(int $nomorSbpInt, int $tahun): string
    {
        return "LPHP-{$nomorSbpInt}/KBC.010202/{$tahun}";
    }
}
