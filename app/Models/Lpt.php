<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\MediaCollection;
use App\Traits\LogsActivity;

class Lpt extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, LogsActivity;

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

    /**
     * Kolom internal (bukan mass-assignable) yang menyimpan nomor_lpt_int hanya untuk
     * baris aktif dan dilindungi unique index di database. Lihat migration
     * add_nomor_lpt_int_active_unique_to_lpt_table.
     */
    protected $hidden = [
        'nomor_lpt_int_active',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($lpt) {
            // Sinkron otomatis di setiap create/update/restore (semuanya lewat save()).
            $lpt->nomor_lpt_int_active = $lpt->trashed() ? null : $lpt->nomor_lpt_int;
        });

        static::deleting(function ($lpt) {
            if (!$lpt->isForceDeleting()) {
                // Soft delete menulis deleted_at lewat query langsung (bukan save()),
                // jadi hook 'saving' di atas tidak ikut jalan. Kosongkan manual supaya
                // nomor_lpt ini bisa dipakai lagi oleh LPT baru.
                $lpt->forceFill(['nomor_lpt_int_active' => null])->saveQuietly();
            }
        });
    }

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
