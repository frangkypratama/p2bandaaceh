<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\MediaCollection;

class Lpt extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photos')->useDisk('local');
    }

    /**
     * Relasi ke tabel lpt_photos lama (pra-Spatie MediaLibrary).
     * Dipertahankan hanya sebagai cadangan/rujukan riwayat migrasi data,
     * bukan untuk dipakai fitur baru - lihat App\Console\Commands\MigrateLptPhotosToMedia.
     */
    public function legacyPhotos()
    {
        return $this->hasMany(LptPhoto::class);
    }
}
