<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class SuratPerintah extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'surat_perintah';

    protected $fillable = [
        'nomor_prin',
        'tanggal_prin',
    ];
}
