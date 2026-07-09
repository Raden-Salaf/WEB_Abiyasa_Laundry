<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Fungsi untuk membuat tabel type_of_service (jenis jasa laundry & harga per kg)
    public function up(): void
    {
        Schema::create('type_of_service', function (Blueprint $table) {
            $table->id(); // primary key auto increment
            $table->string('service_name', 50); // nama jasa, contoh: Cuci & Gosok, Hanya Cuci, dll
            $table->integer('price'); // harga per kg
            $table->text('description')->nullable(); // deskripsi tambahan jasa
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at, untuk soft delete
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('type_of_service');
    }
};