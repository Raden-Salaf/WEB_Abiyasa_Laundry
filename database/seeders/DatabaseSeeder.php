<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Fungsi utama yang memanggil semua seeder lain secara berurutan
    public function run(): void
    {
        $this->call([
            LevelSeeder::class, // harus dijalankan duluan, karena UserSeeder butuh id_level
            UserSeeder::class,
        ]);
    }
}