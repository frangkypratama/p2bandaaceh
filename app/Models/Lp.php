<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lp extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lp';

    protected $fillable = [
        'lphp_id',
        'nomor_lp',
        'tanggal_lp',
        'pejabat_penerbit_id',
    ];

    protected $casts = [
        'tanggal_lp' => 'date',
    ];

    /**
     * Kolom internal (bukan mass-assignable) yang menyimpan lphp_id hanya untuk baris
     * aktif dan dilindungi unique index di database. Lihat migration create_lp_table.
     */
    protected $hidden = [
        'lphp_id_active',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::saving(function ($lp) {
            $lp->lphp_id_active = $lp->trashed() ? null : $lp->lphp_id;
        });

        static::deleting(function ($lp) {
            if ($lp->isForceDeleting()) {
                optional($lp->lpp)->forceDelete();
            } else {
                optional($lp->lpp)->delete();

                $lp->forceFill(['lphp_id_active' => null])->saveQuietly();
            }
        });

        static::restoring(function ($lp) {
            optional($lp->lpp()->withTrashed()->first())->restore();
        });
    }

    public function lphp()
    {
        return $this->belongsTo(Lphp::class);
    }

    public function lpp()
    {
        return $this->hasOne(Lpp::class);
    }

    public function pejabatPenerbit()
    {
        return $this->belongsTo(Petugas::class, 'pejabat_penerbit_id')->withTrashed();
    }

    /**
     * Format nomor LP. Nomor urut mengikuti nomor SBP asalnya,
     * mis. "LP-101/KBC.010202/2026".
     */
    public static function formatNomorLp(int $nomorSbpInt, int $tahun): string
    {
        return "LP-{$nomorSbpInt}/KBC.010202/{$tahun}";
    }
}
