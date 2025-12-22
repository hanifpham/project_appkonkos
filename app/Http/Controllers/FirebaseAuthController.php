<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FirebaseAuthController extends Controller
{
    protected $auth;

    public function __construct(FirebaseAuth $auth)
    {
        $this->auth = $auth;
    }

    public function login(Request $request)
    {
        // 1. Terima Token dari Frontend
        $idTokenString = $request->input('token');

        if (empty($idTokenString)) {
            return response()->json(['status' => 'error', 'message' => 'Token Firebase tidak ditemukan'], 422);
        }

        try {
            // 2. Verifikasi Token ke Server Firebase
            // Leeway 5 menit untuk menghindari isu waktu server yang berbeda (clock skew)
            $verifiedIdToken = $this->auth->verifyIdToken($idTokenString, false, 300);

            // Ambil data user dari token
            $uid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');
            $name = $verifiedIdToken->claims()->get('name') ?? 'User Firebase';

            // 3. Cek apakah user ada di Database MySQL
            $user = User::where('firebase_uid', $uid)->orWhere('email', $email)->first();

            if (!$user) {
                // KASUS A: User Baru -> Buat di MySQL
                $user = User::create([
                    'nama' => $name,
                    'email' => $email,
                    'firebase_uid' => $uid,
                    // Password acak supaya kolom tidak kosong, user tidak dipakai
                    'password' => Str::random(32),
                    'role' => 'user',
                ]);
            } else {
                // KASUS B: User Lama -> Update UID jika belum ada
                if (empty($user->firebase_uid)) {
                    $user->update(['firebase_uid' => $uid]);
                }
            }

            // 4. Login Manual ke Laravel (Session Started)
            Auth::login($user);
            $request->session()->regenerate();

            return response()->json([
                'status' => 'success',
                'message' => 'Login Berhasil',
                'redirect' => route('home'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 401);
        }
    }
}
