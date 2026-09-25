<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Role extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'label',
        'is_admin',
    ];

    protected function casts(): array
    {
        return [
            'is_admin' => 'boolean',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission(string $key): bool
    {
        return $this->is_admin || $this->permissions->contains('key', $key);
    }

    protected static function booted(): void
    {
        static::saved(fn (self $role) => self::forgetCache($role->id));
        static::deleted(fn (self $role) => self::forgetCache($role->id));
    }

    /**
     * Ringkasan role (is_admin + daftar key permission) dari cache, supaya
     * User::hasPermission()/isAdmin() tidak query role+permissions berulang
     * kali tiap request (dipanggil beberapa kali per halaman lewat sidebar).
     */
    public static function cachedSummary(int $roleId): ?array
    {
        return Cache::rememberForever(self::cacheKey($roleId), function () use ($roleId) {
            $role = static::with('permissions')->find($roleId);

            if (! $role) {
                return null;
            }

            return [
                'is_admin' => $role->is_admin,
                'permissions' => $role->permissions->pluck('key')->all(),
            ];
        });
    }

    public static function forgetCache(int $roleId): void
    {
        Cache::forget(self::cacheKey($roleId));
    }

    protected static function cacheKey(int $roleId): string
    {
        return "role-cache:{$roleId}";
    }
}
