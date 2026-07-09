<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Fungsi untuk membuat tabel level (data role: Admin, Operator, Pimpinan)
    public function up(): void
    {
        Schema::create('level', function (Blueprint $table) {
            $table->id(); // primary key auto increment
            $table->string('level_name', 50); // nama level, contoh: Admin, Operator, Pimpinan
            $table->timestamps(); // created_at & updated_at otomatis
            $table->softDeletes(); // kolom deleted_at, untuk soft delete
        });
    }

    // Fungsi untuk rollback / menghapus tabel level
    public function down(): void
    {
        Schema::dropIfExists('level');
    }
};