<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Fungsi untuk membuat tabel trans_order_detail (detail jasa per transaksi)
    public function up(): void
    {
        Schema::create('trans_order_detail', function (Blueprint $table) {
            $table->id(); // primary key auto increment
            $table->foreignId('id_order')->constrained('trans_order')->onDelete('cascade'); // relasi ke trans_order
            $table->foreignId('id_service')->constrained('type_of_service')->onDelete('cascade'); // relasi ke type_of_service
            $table->integer('qty'); // berat/qty dalam kg
            $table->double('subtotal', 10, 2); // subtotal = harga jasa * qty
            $table->text('notes')->nullable(); // catatan tambahan per item
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trans_order_detail');
    }
};