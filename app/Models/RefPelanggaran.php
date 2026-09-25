<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use App\Traits\Cacheable;

class RefPelanggaran extends Model
{
    use HasFactory, LogsActivity, Cacheable;

    protected $table = 'ref_pelanggaran';

    protected $fillable = [
        'pelanggaran',
    ];
}
