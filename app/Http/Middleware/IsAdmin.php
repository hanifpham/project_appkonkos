<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Kalau belum login, arahkan ke login admin
        if (!Auth::check()) {
            return redirect()->route('admin.login.form')->with('error', 'Silakan login sebagai admin.');
        }

        // Kalau login tapi bukan admin, logout dan arahkan ke login user
        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            return redirect()->route('login.form')->with('error', 'Akses ditolak! Anda bukan admin.');
        }

        // Kalau admin → lanjut ke halaman
        return $next($request);
    }
}
