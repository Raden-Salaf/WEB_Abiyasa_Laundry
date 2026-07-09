<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Fungsi untuk menambahkan kolom id_level ke tabel users bawaan Laravel,
    // supaya bisa relasi ke tabel level (Administrator/Operator/Pimpinan) sesuai ERD
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ditaruh setelah kolom 'id', nullable dulu supaya tidak error kalau ada data lama tanpa level
            $table->foreignId('id_level')->nullable()->after('id')->constrained('level')->onDelete('cascade');
        });
    }

    // Fungsi untuk rollback, menghapus kolom id_level
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_level']);
            $table->dropColumn('id_level');
        });
    }
};