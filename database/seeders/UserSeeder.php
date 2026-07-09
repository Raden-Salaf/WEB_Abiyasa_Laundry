<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    // Fungsi untuk membuat akun awal masing-masing role, supaya bisa langsung login & testing
    public function run(): void
    {
        // Ambil id_level berdasarkan nama level yang sudah diisi LevelSeeder
        $admin    = Level::where('level_name', 'Administrator')->first();
        $operator = Level::where('level_name', 'Operator')->first();
        $pimpinan = Level::where('level_name', 'Pimpinan')->first();

        User::create([
            'id_level' => $admin->id,
            'name'     => 'Admin',
            'email'    => 'admin@laundry.com',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'id_level' => $operator->id,
            'name'     => 'Operator',
            'email'    => 'operator@laundry.com',
            'password' => Hash::make('operator123'),
        ]);

        User::create([
            'id_level' => $pimpinan->id,
            'name'     => 'Pimpinan',
            'email'    => 'pimpinan@laundry.com',
            'password' => Hash::make('pimpinan123'),
        ]);
    }
}