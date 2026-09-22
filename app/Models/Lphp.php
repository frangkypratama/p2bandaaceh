<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Lphp extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lphp';

    protected $fillable = [
        'sbp_id',
        'nomor_lphp',
        'tanggal_lphp',
        'dugaan_pelanggaran',
        'uraian_kegiatan',
        'uraian_brg_lphp_lp',
        'nama_tempat',
        'pelaku_tidak_ditemukan',
        'tanggal_lahir',
        'kewarganegaraan',
        'pasal',
        'uu_terkait',
        'konseptor_id',
        'pengampu_id',
        'pemeriksa_id',
        'catatan',
    ];

    protected $casts = [
        'tanggal_lphp' => 'date',
        'tanggal_lahir' => 'date',
        'pelaku_tidak_ditemukan' => 'boolean',
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

    /**
     * Tanggal LPHP default: 6 hari setelah tanggal SBP.
     */
    public static function defaultTanggalLphp(Sbp $sbp): ?Carbon
    {
        return $sbp->tanggal_sbp?->copy()->addDays(6);
    }

    /**
     * Jenis barang yang termasuk kategori pelanggaran Cukai. Jenis barang lain
     * di luar daftar ini dianggap kategori Kepabeanan.
     */
    public static function jenisBarangCukai(): array
    {
        return ['Hasil Tembakau', 'Minuman Mengandung Etil Alkohol', 'Etil Alkohol'];
    }

    /**
     * Tentukan kategori dugaan pelanggaran (Cukai/Kepabeanan) dari jenis barang SBP.
     */
    public static function inferDugaanPelanggaran(?string $jenisBarang): string
    {
        return in_array($jenisBarang, self::jenisBarangCukai(), true) ? 'Cukai' : 'Kepabeanan';
    }

    /**
     * Pasal default sesuai kategori dugaan pelanggaran.
     */
    public static function pasalUntuk(string $dugaanPelanggaran): string
    {
        return $dugaanPelanggaran === 'Cukai' ? 'Pasal 54 dan/atau 56' : 'Pasal 53';
    }

    /**
     * Undang-Undang terkait default sesuai kategori dugaan pelanggaran.
     */
    public static function uuTerkaitUntuk(string $dugaanPelanggaran): string
    {
        return $dugaanPelanggaran === 'Cukai'
            ? 'Undang-Undang Nomor 39 Tahun 2007 tentang Perubahan Atas Undang-Undang Nomor 11 Tahun 1995 tentang Cukai'
            : 'Undang-Undang Nomor 17 Tahun 2006 tentang perubahan Undang-Undang Nomor 10 Tahun 1995 tentang Kepabeanan';
    }

    /**
     * Narasi "Kegiatan Penindakan" default sesuai kategori dugaan pelanggaran:
     * Cukai menyebut lokasi penindakan, Kepabeanan menyebut nama pelaku.
     */
    public static function uraianKegiatanUntuk(string $dugaanPelanggaran, Sbp $sbp): string
    {
        $subjek = $dugaanPelanggaran === 'Cukai' ? $sbp->lokasi_penindakan : $sbp->nama_pelaku;
        $bidang = $dugaanPelanggaran === 'Cukai' ? 'Cukai' : 'Kepabeanan';

        return "Telah dilakukan pemeriksaan, penindakan, penegahan dan penyegelan terhadap {$subjek} yang diduga melanggar ketentuan dibidang {$bidang}";
    }

    /**
     * Saran "Nama Tempat / Toko" dirangkai dari lokasi, kecamatan, dan kota
     * penindakan pada SBP.
     */
    public static function namaTempatUntuk(Sbp $sbp): string
    {
        return collect([
            $sbp->lokasi_penindakan,
            $sbp->kecamatan_penindakan ? 'Kec. ' . $sbp->kecamatan_penindakan : null,
            $sbp->kota_penindakan,
        ])->filter()->implode(', ');
    }

    /**
     * Peta default (pasal, UU terkait, uraian kegiatan) untuk kedua kategori
     * dugaan pelanggaran - dipakai form untuk live-update saat kategori diganti
     * manual, tanpa duplikasi aturan di JS.
     */
    public static function categoryDefaults(Sbp $sbp): array
    {
        return collect(['Cukai', 'Kepabeanan'])->mapWithKeys(function ($kategori) use ($sbp) {
            return [$kategori => [
                'pasal' => self::pasalUntuk($kategori),
                'uu_terkait' => self::uuTerkaitUntuk($kategori),
                'uraian_kegiatan' => self::uraianKegiatanUntuk($kategori, $sbp),
            ]];
        })->all();
    }
}
