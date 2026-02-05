<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Petugas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'petugas';
    protected $fillable = [
        'nama',
        'nip',
        'pangkat',
        'golongan',
        'jabatan',
    ];
    
    public function getNipFormattedAttribute()
    {
        $nip = $this->nip;

        if (strlen($nip) === 18) {
            return Str::substr($nip, 0, 8) . ' ' .
                   Str::substr($nip, 8, 6) . ' ' .
                   Str::substr($nip, 14, 1) . ' ' .
                   Str::substr($nip, 15, 3);
        }

        // Return original NIP if it's not 18 digits
        return $nip;
    }

}
