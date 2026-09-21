<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lpf extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lpf';

    protected $fillable = [
        'lpp_id',
        'nomor_lpf',
        'tanggal_lpf',
        'status_penangkapan',
        'kelengkapan_dokumen',
        'barang_hasil_penindakan',
        'domain_perkara',
        'kesimpulan',
        'usulan',
        'catatan_disposisi',
        'konseptor_id',
        'pengampu_id',
        'pemeriksa_id',
    ];

    protected $casts = [
        'tanggal_lpf' => 'date',
    ];

    /**
     * Kolom internal (bukan mass-assignable) yang menyimpan lpp_id hanya untuk baris
     * aktif dan dilindungi unique index di database. Lihat migration create_lpf_table.
     */
    protected $hidden = [
        'lpp_id_active',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::saving(function ($lpf) {
            $lpf->lpp_id_active = $lpf->trashed() ? null : $lpf->lpp_id;
        });

        static::deleting(function ($lpf) {
            if ($lpf->isForceDeleting()) {
                optional($lpf->split)->forceDelete();
            } else {
                optional($lpf->split)->delete();

                $lpf->forceFill(['lpp_id_active' => null])->saveQuietly();
            }
        });

        static::restoring(function ($lpf) {
            optional($lpf->split()->withTrashed()->first())->restore();
        });
    }

    public function lpp()
    {
        return $this->belongsTo(Lpp::class);
    }

    public function split()
    {
        return $this->hasOne(Split::class);
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
     * Format nomor LPF. Nomor urut mengikuti nomor SBP asalnya,
     * mis. "LPF-91/KBC.010202/2026".
     */
    public static function formatNomorLpf(int $nomorSbpInt, int $tahun): string
    {
        return "LPF-{$nomorSbpInt}/KBC.010202/{$tahun}";
    }

    /**
     * Saran narasi "Domain Perkara" default.
     */
    public static function defaultDomainPerkara(): string
    {
        return 'KPPBC Tipe Madya Pabean C Banda Aceh sesuai dengan tempat ditemukannya barang hasil penindakan.';
    }

    /**
     * Saran narasi "Kesimpulan" default (poin lengkap/cukup tidaknya berkas, barang bukti,
     * alat bukti, keberadaan pelaku, keterkaitan, dan indikasi pelanggaran).
     */
    public static function defaultKesimpulan(): string
    {
        return "Lengkap tidaknya berkas penindakan: Cukup.\n"
            . "Cukup tidaknya barang bukti: Cukup.\n"
            . "Cukup tidaknya alat bukti: Cukup.\n"
            . "Keberadaan pelaku: Ada.\n"
            . "Keterkaitan alat bukti, barang bukti dan pelaku: Ada.\n"
            . 'Ada tidaknya indikasi pelanggaran: Ada.';
    }
}
