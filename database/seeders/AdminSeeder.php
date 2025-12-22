<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun admin
        User::updateOrCreate(
            ['email' => 'admin@koskon.com'],
            [
                'nama' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Buat akun user biasa
        User::updateOrCreate(
            ['email' => 'test1@koskon.com'],
            [
                'nama' => 'Test1',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );
    }
}
