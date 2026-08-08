<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PencacahanSbp extends Pivot
{
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

    /**
     * Get all of the photos for the pivot record.
     */
    public function photos(): HasMany
    {
        return $this->hasMany(PencacahanPhoto::class, 'pencacahan_sbp_id');
    }
}
