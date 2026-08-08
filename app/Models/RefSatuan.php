<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class RefSatuan
 *
 * @property int $id
 * @property string $nama_satuan
 * @package App\Models
 */
class RefSatuan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ref_satuan';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the jenis barang that belong to the satuan.
     */
    public function jenisBarangs(): HasMany
    {
        return $this->hasMany(RefJenisBarang::class, 'id_satuan_default');
    }
}
