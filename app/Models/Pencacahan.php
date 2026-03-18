<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pencacahan extends Model
{
    protected $table = 'pencacahan';

    protected $fillable = [
        'no_ba_cacah',
        'tanggal_ba_cacah',
        'lokasi_cacah',
        'id_petugas_1',
        'id_petugas_2',
    ];

    public function petugas1(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'id_petugas_1');
    }

    public function petugas2(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'id_petugas_2');
    }
}
