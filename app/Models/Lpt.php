<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lpt extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lpt';

    protected $fillable = [
        'nomor_lpt',
        'nomor_lpt_int',
        'tanggal_lpt',
        'jenis_lpt',
        'sbp_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_lpt' => 'date',
    ];

    public function sbp()
    {
        return $this->belongsTo(Sbp::class);
    }

    public function photos()
    {
        return $this->hasMany(LptPhoto::class);
    }
}
