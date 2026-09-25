<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use App\Traits\LogsActivity;

class Lpf extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'lpf';

    protected $fillable = [
        'lpp_id',
        'nomor_lpf',
        'tanggal_lpf',
        'status_penangkapan',
        'nomor_surat_limpahan',
        'tanggal_surat_limpahan',
        'nomor_baw_saksi',
        'tanggal_baw_saksi',
        'nomor_bap_tersangka',
        'tanggal_bap_tersangka',
        'nomor_resume_perkara',
        'tanggal_resume_perkara',
        'nomor_dokumen_lain',
        'tanggal_dokumen_lain',
        'barang_hasil_penindakan',
        'domain_perkara',
        'lengkap_berkas',
        'cukup_barang_bukti',
        'cukup_alat_bukti',
        'keberadaan_pelaku',
        'keterkaitan_bukti_pelaku',
        'indikasi_pelanggaran',
        'kesimpulan',
        'usulan',
        'catatan_disposisi',
        'konseptor_id',
        'pengampu_id',
        'pemeriksa_id',
    ];

    protected $casts = [
        'tanggal_lpf' => 'date',
        'tanggal_surat_limpahan' => 'date',
        'tanggal_baw_saksi' => 'date',
        'tanggal_bap_tersangka' => 'date',
        'tanggal_resume_perkara' => 'date',
        'tanggal_dokumen_lain' => 'date',
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
     * Tanggal LPF default: 5 hari setelah tanggal LPP.
     */
    public static function defaultTanggalLpf(Lpp $lpp): ?Carbon
    {
        return $lpp->tanggal_lpp?->copy()->addDays(5);
    }

    /**
     * Saran narasi "Domain Perkara" default.
     */
    public static function defaultDomainPerkara(): string
    {
        return 'KPPBC Tipe Madya Pabean C Banda Aceh sesuai dengan tempat ditemukannya barang hasil penindakan.';
    }

    /**
     * Pilihan dropdown untuk poin "Lengkap/Cukup tidaknya ..." pada D. Kesimpulan.
     */
    public static function opsiCukup(): array
    {
        return ['Cukup', 'Tidak Lengkap'];
    }

    /**
     * Pilihan dropdown untuk poin "Ada tidaknya ..." pada D. Kesimpulan.
     */
    public static function opsiAda(): array
    {
        return ['Ada', 'Tidak Ada'];
    }

    /**
     * Susun ringkasan naratif dari 6 poin D. Kesimpulan (dipakai sebagai isi kolom
     * "kesimpulan" - dipertahankan untuk kompatibilitas tampilan lama seperti cetak
     * gabungan berkas penyidikan yang masih membaca $lpf->kesimpulan sebagai teks).
     */
    public static function composeKesimpulan(
        string $lengkapBerkas,
        string $cukupBarangBukti,
        string $cukupAlatBukti,
        string $keberadaanPelaku,
        string $keterkaitanBuktiPelaku,
        string $indikasiPelanggaran
    ): string {
        return "Lengkap tidaknya berkas penindakan: {$lengkapBerkas}.\n"
            . "Cukup tidaknya barang bukti: {$cukupBarangBukti}.\n"
            . "Cukup tidaknya alat bukti: {$cukupAlatBukti}.\n"
            . "Keberadaan pelaku: {$keberadaanPelaku}.\n"
            . "Keterkaitan alat bukti, barang bukti dan pelaku: {$keterkaitanBuktiPelaku}.\n"
            . "Ada tidaknya indikasi pelanggaran: {$indikasiPelanggaran}.";
    }
}
