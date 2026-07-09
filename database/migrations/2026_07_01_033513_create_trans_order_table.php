<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Fungsi untuk membuat tabel trans_order (header transaksi laundry)
    public function up(): void
    {
        Schema::create('trans_order', function (Blueprint $table) {
            $table->id(); // primary key auto increment
            $table->foreignId('id_customer')->constrained('customer')->onDelete('cascade'); // relasi ke customer
            $table->string('order_code', 30); // kode unik transaksi, contoh: TRX-20260701-001
            $table->date('order_date'); // tanggal masuk laundry
            $table->date('order_end_date')->nullable(); // tanggal estimasi/actual selesai
            $table->tinyInteger('order_status')->default(0); // status: 0 = baru, 1 = sudah diambil
            $table->integer('order_pay')->default(0); // jumlah uang dibayarkan customer
            $table->integer('order_change')->default(0); // kembalian
            $table->integer('total')->default(0); // total harga transaksi
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at, untuk soft delete
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trans_order');
    }
};