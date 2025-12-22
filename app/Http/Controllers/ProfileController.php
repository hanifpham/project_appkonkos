<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the profile page along with booking history.
     */
    public function index()
    {
        $user = Auth::user();

        $bookings = Booking::with(['kosan', 'kontrakan'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('user.profile.index', compact('user', 'bookings'));
    }

    /**
     * Update the authenticated user's personal information.
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'telepon' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($validated);

        return redirect()
            ->route('user.profile')
            ->with('success', 'Informasi profil berhasil diperbarui.');
    }
}
