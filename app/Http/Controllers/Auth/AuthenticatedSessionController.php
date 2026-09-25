<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Maksimal percobaan login gagal (per NIP + alamat IP) sebelum diblokir sementara.
     */
    protected const MAX_ATTEMPTS = 5;

    /**
     * Lama blokir dalam detik setelah percobaan melebihi batas.
     */
    protected const DECAY_SECONDS = 60;

    public function __construct(protected RateLimiter $limiter)
    {
    }

    /**
     * Tampilkan halaman login.
     */
    public function create(): \Illuminate\View\View
    {
        return view('auth.login');
    }

    /**
     * Proses autentikasi menggunakan NIP.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'nip' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $credentials['nip'] = preg_replace('/\s+/', '', $credentials['nip']);

        $throttleKey = $this->throttleKey($request, $credentials['nip']);

        if ($this->limiter->tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $seconds = $this->limiter->availableIn($throttleKey);

            $this->logFailedAttempt($request, "Login diblokir sementara (terlalu banyak percobaan, coba lagi dalam {$seconds} detik)");

            throw ValidationException::withMessages([
                'nip' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            $this->limiter->hit($throttleKey, self::DECAY_SECONDS);

            $this->logFailedAttempt($request, "Percobaan login gagal untuk NIP {$credentials['nip']}");

            throw ValidationException::withMessages([
                'nip' => 'NIP atau password yang Anda masukkan salah.',
            ]);
        }

        $this->limiter->clear($throttleKey);

        $request->session()->regenerate();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'login',
            'description' => Auth::user()->name.' login ke sistem',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Kunci rate limiter unik per kombinasi NIP + IP, supaya satu NIP yang
     * diserang tidak ikut mengunci NIP lain di jaringan/kantor yang sama.
     */
    protected function throttleKey(Request $request, string $nip): string
    {
        return Str::lower($nip).'|'.$request->ip();
    }

    protected function logFailedAttempt(Request $request, string $description): void
    {
        ActivityLog::create([
            'action' => 'login_failed',
            'description' => $description,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    /**
     * Logout dan hapus sesi.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        ActivityLog::create([
            'user_id' => $user?->id,
            'action' => 'logout',
            'description' => ($user->name ?? 'Pengguna').' logout dari sistem',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('login');
    }
}
