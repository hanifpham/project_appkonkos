<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Tampilkan semua user
     */
    public function index()
    {
        $data = User::all();
        return view('admin.users.index', compact('data'));
    }

    /**
     * Tampilkan form tambah user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
            'role' => 'required',
        ], [
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 5 karakter',
            'password.confirmed' => 'Password tidak cocok',
            'role.required' => 'Role harus diisi',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User baru berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit user
     */
    // public function edit($id)
    // {
    //     $user = User::findOrFail($id);
    //     return view('admin.users.edit', compact('user'));
    // }

    // /**
    //  * Update data user
    //  */
    // public function update(Request $request, $id)
    // {
    //     $user = User::findOrFail($id);

    //     $request->validate([
    //         'nama' => 'required',
    //         'email' => 'required|email|unique:users,email,' . $user->id,
    //         'password' => 'nullable|min:5|confirmed',
    //         'role' => 'required',
    //     ], [
    //         'nama.required' => 'Nama harus diisi',
    //         'email.required' => 'Email harus diisi',
    //         'email.email' => 'Format email tidak valid',
    //         'email.unique' => 'Email sudah digunakan',
    //         'password.min' => 'Password minimal 5 karakter',
    //         'password.confirmed' => 'Password tidak cocok',
    //         'role.required' => 'Role harus diisi',
    //     ]);

    //     // kalau password diisi, ganti password lama
    //     if ($request->filled('password')) {
    //         $user->update([
    //             'nama' => $request->nama,
    //             'email' => $request->email,
    //             'password' => Hash::make($request->password),
    //             'role' => $request->role,
    //         ]);
    //     } else {
    //         // kalau kosong, jangan ubah password
    //         $user->update([
    //             'nama' => $request->nama,
    //             'email' => $request->email,
    //             'role' => $request->role,
    //         ]);
    //     }

    //     return redirect()->route('admin.users.index')
    //         ->with('success', 'Data user berhasil diperbarui!');
    // }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Hapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $nama = $user->nama; 
        $user->delete(); 
        return back()->with('success', 'Data ' . $nama . ' berhasil dihapus.');
    }
}