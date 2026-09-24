<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lpp extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lpp';

    protected $fillable = [
        'lp_id',
        'nomor_lpp',
        'tanggal_lpp',
        'asal_perkara',
        'jenis_penindakan',
        'status_pelanggaran',
        'uraian_pelanggaran',
        'dokumen_barang',
        'catatan_atasan',
        'konseptor_id',
        'pengampu_id',
        'pemeriksa_id',
    ];

    protected $casts = [
        'tanggal_lpp' => 'date',
    ];

    /**
     * Kolom internal (bukan mass-assignable) yang menyimpan lp_id hanya untuk baris
     * aktif dan dilindungi unique index di database. Lihat migration create_lpp_table.
     */
    protected $hidden = [
        'lp_id_active',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::saving(function ($lpp) {
            $lpp->lp_id_active = $lpp->trashed() ? null : $lpp->lp_id;
        });

        static::deleting(function ($lpp) {
            if ($lpp->isForceDeleting()) {
                optional($lpp->lpf)->forceDelete();
            } else {
                optional($lpp->lpf)->delete();

                $lpp->forceFill(['lp_id_active' => null])->saveQuietly();
            }
        });

        static::restoring(function ($lpp) {
            optional($lpp->lpf()->withTrashed()->first())->restore();
        });
    }

    public function lp()
    {
        return $this->belongsTo(Lp::class);
    }

    public function lpf()
    {
        return $this->hasOne(Lpf::class);
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
     * Format nomor LPP. Nomor urut mengikuti nomor SBP asalnya,
     * mis. "LPP-91/KBC.010202/2026".
     */
    public static function formatNomorLpp(int $nomorSbpInt, int $tahun): string
    {
        return "LPP-{$nomorSbpInt}/KBC.010202/{$tahun}";
    }
}
