<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lhp extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lhp';

    protected $fillable = [
        'split_id',
        'nomor_lhp',
        'tanggal_lhp',
        'jenis_pelanggaran',
        'pelaku_administrasi',
        'saksi_saksi',
        'uraian_barang_tambahan',
        'sarana_pengangkut',
        'dokumen_dokumen',
        'modus_pelanggaran',
        'pemenuhan_unsur_pasal',
        'kesimpulan',
        'alternatif_penyelesaian',
        'informasi_lainnya',
        'catatan_atasan',
        'konseptor_id',
        'pengampu_id',
        'pemeriksa_id',
    ];

    protected $casts = [
        'tanggal_lhp' => 'date',
    ];

    /**
     * Kolom internal (bukan mass-assignable) yang menyimpan split_id hanya untuk baris
     * aktif dan dilindungi unique index di database. Lihat migration create_lhp_table.
     */
    protected $hidden = [
        'split_id_active',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::saving(function ($lhp) {
            $lhp->split_id_active = $lhp->trashed() ? null : $lhp->split_id;
        });

        static::deleting(function ($lhp) {
            if (!$lhp->isForceDeleting()) {
                $lhp->forceFill(['split_id_active' => null])->saveQuietly();
            }
        });
    }

    public function split()
    {
        return $this->belongsTo(Split::class);
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
     * Format nomor LHP. Nomor urut mengikuti nomor SBP asalnya,
     * mis. "LHP-91/KBC.010202/2026".
     */
    public static function formatNomorLhp(int $nomorSbpInt, int $tahun): string
    {
        return "LHP-{$nomorSbpInt}/KBC.010202/{$tahun}";
    }
}
