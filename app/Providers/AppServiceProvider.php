<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ==========================================
        // 1. LOGIKA HTTPS (KODE LAMA ANDA)
        // ==========================================

        // Paksa HTTPS jika request/proxy memakai HTTPS atau APP_URL sudah HTTPS.
        $appUrl = config('app.url');
        $forwardedProto = request()->header('x-forwarded-proto');
        $forceHttpsEnv = filter_var(env('FORCE_HTTPS', false), FILTER_VALIDATE_BOOLEAN);
        $shouldForceHttps = false;

        if ($forceHttpsEnv || $this->app->environment('production')) {
            $shouldForceHttps = true;
        }

        if (is_string($appUrl) && str_starts_with($appUrl, 'https://')) {
            $shouldForceHttps = true;
        }

        if (is_string($forwardedProto) && str_contains($forwardedProto, 'https')) {
            $shouldForceHttps = true;
        }

        if ($shouldForceHttps) {
            URL::forceScheme('https');
        }

        // ==========================================
        // 2. LOGIKA PERBAIKAN FIREBASE JSON (BARU)
        // ==========================================

        // Tentukan lokasi file tujuan
        $credentialPath = storage_path('app/firebase_credentials.json');

        // Cek apakah file TIDAK ada?
        if (!file_exists($credentialPath)) {
            // Ambil isi JSON dari Environment Variable Railway
            $content = env('FIREBASE_CREDENTIALS');

            // Jika variable ada isinya, buat file fisiknya sekarang
            if ($content) {
                file_put_contents($credentialPath, $content);
            }
        }
    }
}
