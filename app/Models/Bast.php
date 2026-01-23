<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bast extends Model
{
    use HasFactory;

    protected $table = 'bast';

    protected $fillable = [
        'nomor_bast',
        'tanggal_bast',
        'jenis_dokumen',
        'tanggal_dokumen',
        'petugas_eksternal',
        'nip_nrp_petugas_eksternal',
        'instansi_eksternal',
        'dalam_rangka',
        'sbp_id',
    ];

    protected $casts = [
        'tanggal_bast' => 'date',
        'tanggal_dokumen' => 'date',
    ];

    public function sbp()
    {
        return $this->belongsTo(Sbp::class);
    }
}
