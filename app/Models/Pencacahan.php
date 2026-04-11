<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
    public function petugas1(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'id_petugas_1');
    }

    /**
     * Get the second officer associated with the pencacahan.
     */
    public function petugas2(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'id_petugas_2');
    }

    /**
     * The sbp that belong to the Pencacahan.
     */
    public function sbp(): BelongsToMany
    {
        return $this->belongsToMany(Sbp::class, 'pencacahan_sbp', 'pencacahan_id', 'sbp_id')
                    ->using(PencacahanSbp::class) // Gunakan model pivot kustom
                    ->withPivot('id')
                    ->withTimestamps();
    }

    /**
     * Get all of the details for the Pencacahan through the SBP pivot table.
     */
    public function details(): HasManyThrough
    {
        return $this->hasManyThrough(
            DetailPencacahan::class,
            PencacahanSbp::class,
            'pencacahan_id', // Foreign key on PencacahanSbp table...
            'pencacahan_sbp_id', // Foreign key on DetailPencacahan table...
            'id', // Local key on Pencacahan table...
            'id' // Local key on PencacahanSbp table...
        );
    }

    /**
     * Get all of the photos for the Pencacahan through the SBP pivot table.
     */
    public function photos(): HasManyThrough
    {
        return $this->hasManyThrough(
            PencacahanPhoto::class,
            PencacahanSbp::class,
            'pencacahan_id', // Foreign key on PencacahanSbp table...
            'pencacahan_sbp_id', // Foreign key on PencacahanPhoto table...
            'id', // Local key on Pencacahan table...
            'id' // Local key on PencacahanSbp table...
        );
    }
}
