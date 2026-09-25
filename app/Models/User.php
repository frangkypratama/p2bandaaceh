<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\LogsActivity;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nip',
        'role_id',
        'petugas_id',
        'email',
        'password',
    ];

    /**
     * Data petugas yang berkaitan dengan akun login ini (opsional —
     * tidak semua petugas punya akun, dan akun ini bisa juga tanpa petugas).
     */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Admin (role dengan is_admin = true) selalu punya akses penuh,
     * di luar matrix permission per role.
     *
     * Dibaca dari cache (Role::cachedSummary) supaya sidebar & middleware yang
     * memanggil ini berkali-kali per request tidak query role+permissions
     * berulang-ulang ke database.
     */
    public function isAdmin(): bool
    {
        if (! $this->role_id) {
            return false;
        }

        return (bool) (Role::cachedSummary($this->role_id)['is_admin'] ?? false);
    }

    /**
     * Cek apakah user boleh mengakses modul tertentu (mis. 'sbp', 'lphp').
     */
    public function hasPermission(string $key): bool
    {
        if (! $this->role_id) {
            return false;
        }

        $summary = Role::cachedSummary($this->role_id);

        if (! $summary) {
            return false;
        }

        return $summary['is_admin'] || in_array($key, $summary['permissions'], true);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
