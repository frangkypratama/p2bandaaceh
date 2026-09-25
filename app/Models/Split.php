<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use App\Traits\LogsActivity;

class Split extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'split';

    protected $fillable = [
        'lpf_id',
        'nomor_split',
        'tanggal_split',
        'dasar',
        'pertimbangan',
        'petugas1_id',
        'petugas2_id',
        'uraian_tugas',
        'penerbit_id',
    ];

    protected $casts = [
        'tanggal_split' => 'date',
    ];

    /**
     * Kolom internal (bukan mass-assignable) yang menyimpan lpf_id hanya untuk baris
     * aktif dan dilindungi unique index di database. Lihat migration create_split_table.
     */
    protected $hidden = [
        'lpf_id_active',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::saving(function ($split) {
            $split->lpf_id_active = $split->trashed() ? null : $split->lpf_id;
        });

        static::deleting(function ($split) {
            if ($split->isForceDeleting()) {
                optional($split->lhp)->forceDelete();
            } else {
                optional($split->lhp)->delete();

                $split->forceFill(['lpf_id_active' => null])->saveQuietly();
            }
        });

        static::restoring(function ($split) {
            optional($split->lhp()->withTrashed()->first())->restore();
        });
    }

    public function lpf()
    {
        return $this->belongsTo(Lpf::class);
    }

    public function lhp()
    {
        return $this->hasOne(Lhp::class);
    }

    public function petugas1()
    {
        return $this->belongsTo(Petugas::class, 'petugas1_id')->withTrashed();
    }

    public function petugas2()
    {
        return $this->belongsTo(Petugas::class, 'petugas2_id')->withTrashed();
    }

    public function penerbit()
    {
        return $this->belongsTo(Petugas::class, 'penerbit_id')->withTrashed();
    }

    /**
     * Format nomor SPLIT. Nomor urut mengikuti nomor SBP asalnya,
     * mis. "SPLIT-91/KBC.010202/2026".
     */
    public static function formatNomorSplit(int $nomorSbpInt, int $tahun): string
    {
        return "SPLIT-{$nomorSbpInt}/KBC.010202/{$tahun}";
    }

    /**
     * Tanggal SPLIT default: sama dengan tanggal LPF.
     */
    public static function defaultTanggalSplit(Lpf $lpf): ?Carbon
    {
        return $lpf->tanggal_lpf?->copy();
    }

    /**
     * Saran narasi "Dasar" hukum, merujuk nomor LP asal.
     */
    public static function defaultDasar(Lp $lp): string
    {
        return "Undang-Undang Nomor 10 Tahun 1995 tentang Kepabeanan sebagaimana telah diubah dengan Undang-Undang Nomor 17 Tahun 2006;\n"
            . "Undang-Undang Nomor 11 Tahun 1995 tentang Cukai sebagaimana telah beberapa kali diubah terakhir dengan Undang-Undang Nomor 7 Tahun 2021 tentang Harmonisasi Peraturan Perpajakan;\n"
            . "Peraturan Menteri Keuangan Nomor 188/PMK.01/2016 tentang Organisasi dan Tata Kerja Instansi Vertikal Direktorat Jenderal Bea dan Cukai sebagaimana telah diubah dengan Peraturan Menteri Keuangan Nomor 183/PMK.04/2021;\n"
            . "Laporan Pelanggaran dari Unit Penindakan: {$lp->nomor_lp} Tanggal " . optional($lp->tanggal_lp)->translatedFormat('d F Y') . '.';
    }

    /**
     * Saran narasi "Pertimbangan" default.
     */
    public static function defaultPertimbangan(): string
    {
        return 'Bahwa dengan adanya Laporan Pelanggaran diduga pelanggaran di bidang kepabeanan dan/atau cukai, maka dipandang perlu untuk mengumpulkan bahan keterangan dan menemukan bukti permulaan yang cukup akan adanya tindak pidana kepabeanan dan/atau cukai. Bahwa untuk maksud tersebut perlu dikeluarkan Surat Perintah Penelitian.';
    }

    /**
     * Saran narasi "Untuk" (uraian tugas) default. Data pelaku (nama, alamat, dsb) ditampilkan
     * terpisah di atas teks ini pada template cetak, sehingga tidak diulang di sini.
     */
    public static function defaultUraianTugas(): string
    {
        return "Melakukan tugas penelitian berupa mencari, mengumpulkan bahan keterangan, dan menemukan bukti permulaan yang cukup atas perkara yang diduga dilakukan oleh :\n"
            . 'Setelah melaksanakan Surat Perintah ini agar melaporkan kepada yang memberi perintah.';
    }
}
