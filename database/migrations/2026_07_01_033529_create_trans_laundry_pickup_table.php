<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Fungsi untuk membuat tabel trans_laundry_pickup (catatan pengambilan pakaian)
    public function up(): void
    {
        Schema::create('trans_laundry_pickup', function (Blueprint $table) {
            $table->id(); // primary key auto increment
            $table->foreignId('id_order')->constrained('trans_order')->onDelete('cascade'); // relasi ke trans_order
            $table->foreignId('id_customer')->constrained('customer')->onDelete('cascade'); // relasi ke customer
            $table->dateTime('pickup_date'); // tanggal & jam pengambilan
            $table->text('notes')->nullable(); // catatan saat pengambilan
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trans_laundry_pickup');
    }
};