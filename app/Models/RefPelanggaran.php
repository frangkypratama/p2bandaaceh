<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'ref_pelanggaran';

    protected $fillable = [
        'pelanggaran',
    ];
}
