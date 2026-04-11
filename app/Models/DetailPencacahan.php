<?php

namespace App\Models;

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
}
