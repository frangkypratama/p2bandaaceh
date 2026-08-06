<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPencacahan extends Model
{
    use HasFactory;

    protected $table = 'detail_pencacahan';

    protected $fillable = [
        'pencacahan_sbp_id',
        'id_jenis_barang',
        'kondisi_barang',
        'urutan',
        'id_satuan',
        'id_ref_tarif_cukai',
        'merek',
        'uraian',
        'jumlah',
        'berat',
        'volume',
        'jumlah_bungkus',
        'jumlah_batang',
        'total_batang',
        'imei1',
        'imei2',
        'warna',
        'model_seri',
        'ukuran',
        'tipe',
        'nomor_rangka',
        'nomor_mesin',
        'kadar_alkohol',
        'jumlah_botol',
        'nama_zat',
        'jenis_zat',
        'bentuk_sediaan',
        'jumlah_kemasan',
        'jenis_kendaraan',
        'jenis_mmea',
        'jenis_rokok',
        'mata_uang',
        'tahun',
        'nama_produk',
        'no_izin_edar',
        'tanggal_kadaluwarsa',
        'nama_obat',
        'jenis_elektronik',
        'no_bpom',
    ];

    /**
     * Get the parent pivot record.
     */
    public function pencacahanSbp(): BelongsTo
    {
        return $this->belongsTo(PencacahanSbp::class, 'pencacahan_sbp_id');
    }

    /**
     * Get the type of the item (jenis barang).
     */
    public function jenisBarang(): BelongsTo
    {
        return $this->belongsTo(RefJenisBarang::class, 'id_jenis_barang');
    }
    
    /**
     * Mendapatkan data satuan yang terkait dengan detail pencacahan.
     */
    public function satuan(): BelongsTo
    {
        return $this->belongsTo(RefSatuan::class, 'id_satuan');
    }

    /**
     * Representasi kuantitas barang untuk ditampilkan (di halaman detail maupun cetak PDF).
     *
     * Kolom yang menyimpan "jumlah" berbeda-beda tergantung jenis barang (lihat
     * partials.fields._conditional): Hasil Tembakau pakai total_batang, MMEA/Etil
     * Alkohol/Crude Oil/CPO pakai jumlah_botol, Narkotika pakai jumlah_kemasan, dst.
     * Jenis barang yang formnya tidak punya field kuantitas sama sekali (Handphone,
     * Elektronik, Kendaraan, Senjata Api, Kosmetik) dianggap 1 baris = 1 unit.
     */
    protected function jumlahTampil(): Attribute
    {
        return Attribute::make(get: function () {
            if (!is_null($this->jumlah)) {
                $unit = optional($this->satuan)->nama_satuan;
                return $this->jumlah . ($unit ? ' ' . $unit : '');
            }

            if (!is_null($this->total_batang)) {
                return $this->total_batang . ' Batang';
            }

            if (!is_null($this->jumlah_botol)) {
                return $this->jumlah_botol . ' Botol/Wadah';
            }

            if (!is_null($this->jumlah_kemasan)) {
                return $this->jumlah_kemasan . ' Kemasan';
            }

            if (!is_null($this->berat)) {
                return rtrim(rtrim(number_format($this->berat, 2, ',', '.'), '0'), ',') . ' gram';
            }

            if (!is_null($this->volume)) {
                return rtrim(rtrim(number_format($this->volume, 2, ',', '.'), '0'), ',');
            }

            return '1';
        });
    }
}
