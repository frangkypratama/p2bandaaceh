<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefJenisBarang extends Model
{
    use HasFactory;

    protected $table = 'ref_jenis_barang';

    protected $fillable = ['nomor_urut', 'nama_barang'];
}
