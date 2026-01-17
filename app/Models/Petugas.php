<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Petugas extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'petugas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'nip',
        'pangkat',
        'golongan',
        'jabatan',
    ];

    /**
     * Get the formatted NIP attribute.
     *
     * @return string
     */
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
