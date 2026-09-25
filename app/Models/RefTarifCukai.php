<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;
use App\Traits\Cacheable;

class RefTarifCukai extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, Cacheable;

    protected $table = 'ref_tarif_cukai';

    protected $fillable = [
        'jenis',
        'golongan',
        'hje_min',
        'hje_max',
        'tarif',
    ];
}
