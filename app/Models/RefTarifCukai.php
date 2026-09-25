<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class RefTarifCukai extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'ref_tarif_cukai';

    protected $fillable = [
        'jenis',
        'golongan',
        'hje_min',
        'hje_max',
        'tarif',
    ];
}
