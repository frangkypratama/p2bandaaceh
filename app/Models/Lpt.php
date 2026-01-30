<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lpt extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lpt';

    protected $fillable = [
        'nomor_lpt',
        'tanggal_lpt',
        'jenis_lpt',
        'sbp_id',
    ];

    public function sbp()
    {
        return $this->belongsTo(Sbp::class);
    }
}
