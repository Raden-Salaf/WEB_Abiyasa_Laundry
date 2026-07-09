<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    // Fungsi untuk mengisi data awal tabel level sesuai role di dokumentasi:
    // Administrator/Super Admin, Operator, Pimpinan
    public function run(): void
    {
        Level::create(['level_name' => 'Administrator']);
        Level::create(['level_name' => 'Operator']);
        Level::create(['level_name' => 'Pimpinan']);
    }
}