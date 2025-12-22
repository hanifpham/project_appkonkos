<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- Jangan lupa baris ini!

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
        // Paksa HTTPS jika request/proxy memakai HTTPS atau APP_URL sudah HTTPS.
        $appUrl = config('app.url');
        $forwardedProto = request()->header('x-forwarded-proto');
        $shouldForceHttps = false;

        if (is_string($appUrl) && str_starts_with($appUrl, 'https://')) {
            $shouldForceHttps = true;
        }

        if (is_string($forwardedProto) && str_contains($forwardedProto, 'https')) {
            $shouldForceHttps = true;
        }

        if ($shouldForceHttps) {
            URL::forceScheme('https');
        }
    }
}
