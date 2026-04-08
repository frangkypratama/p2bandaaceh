<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RefTarifCukai extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ref_tarif_cukai';

    protected $fillable = [
        'jenis',
        'golongan',
        'hje_min',
        'hje_max',
        'tarif',
    ];
}
