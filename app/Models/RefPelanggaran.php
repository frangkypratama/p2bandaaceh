<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class RefPelanggaran extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'ref_pelanggaran';

    protected $fillable = [
        'pelanggaran',
    ];
}
