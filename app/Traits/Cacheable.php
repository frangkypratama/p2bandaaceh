<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

/**
 * Cache seluruh baris tabel referensi (jarang berubah, sering dibaca untuk
 * dropdown). Cache otomatis dibersihkan tiap ada create/update/delete lewat
 * Eloquent model events, jadi tidak pernah basi.
 */
trait Cacheable
{
    public static function bootCacheable(): void
    {
        static::saved(fn () => static::forgetCache());
        static::deleted(fn () => static::forgetCache());
    }

    /**
     * Ambil semua baris, dari cache kalau ada.
     */
    public static function cached()
    {
        return Cache::rememberForever(static::cacheKey(), function () {
            $query = static::query();

            if ($column = static::cacheOrderBy()) {
                $query->orderBy($column);
            }

            return $query->get();
        });
    }

    public static function forgetCache(): void
    {
        Cache::forget(static::cacheKey());
    }

    protected static function cacheKey(): string
    {
        return 'ref-cache:'.(new static)->getTable();
    }

    /**
     * Override di model kalau perlu urutan tertentu, mis. 'nama_satuan'.
     */
    protected static function cacheOrderBy(): ?string
    {
        return null;
    }
}
