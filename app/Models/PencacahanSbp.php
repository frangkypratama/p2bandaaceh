<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PencacahanSbp extends Pivot implements HasMedia
{
    use InteractsWithMedia;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    protected $table = 'pencacahan_sbp';

    /**
     * Get the pencacahan that owns the pivot record.
     */
    public function pencacahan(): BelongsTo
    {
        return $this->belongsTo(Pencacahan::class);
    }

    /**
     * Get the sbp that owns the pivot record.
     */
    public function sbp(): BelongsTo
    {
        return $this->belongsTo(Sbp::class);
    }

    /**
     * Get all of the details for the pivot record.
     */
    public function details(): HasMany
    {
        return $this->hasMany(DetailPencacahan::class, 'pencacahan_sbp_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('foto')->useDisk('local')->singleFile();
    }

    /**
     * Relasi ke tabel pencacahan_photos lama (pra-Spatie MediaLibrary).
     * Dipertahankan hanya sebagai cadangan/rujukan riwayat migrasi data,
     * bukan untuk dipakai fitur baru - lihat App\Console\Commands\MigratePencacahanPhotosToMedia.
     */
    public function legacyPhotos(): HasMany
    {
        return $this->hasMany(PencacahanPhoto::class, 'pencacahan_sbp_id');
    }
}
