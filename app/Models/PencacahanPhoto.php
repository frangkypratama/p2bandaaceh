<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PencacahanPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'pencacahan_sbp_id',
        'path',
        'filename',
    ];

    public function pencacahanSbp()
    {
        return $this->belongsTo(PencacahanSbp::class);
    }
}
