<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencacahan extends Model
{
    use HasFactory;

    protected $table = 'pencacahan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_ba_cacah',
        'tanggal_ba_cacah',
        'lokasi_cacah',
        'id_petugas_1',
        'id_petugas_2',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_ba_cacah' => 'date',
    ];

    /**
     * Get the first officer associated with the pencacahan.
     */
    public function petugas1()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas_1');
    }

    /**
     * Get the second officer associated with the pencacahan.
     */
    public function petugas2()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas_2');
    }

    /**
     * The SBP documents that belong to the pencacahan.
     */
    public function sbp()
    {
        return $this->belongsToMany(Sbp::class, 'pencacahan_sbp', 'pencacahan_id', 'sbp_id');
    }
}
