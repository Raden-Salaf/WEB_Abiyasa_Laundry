<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Fungsi untuk membuat tabel customer (data pelanggan laundry)
    public function up(): void
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->id(); // primary key auto increment
            $table->string('customer_name', 50); // nama customer
            $table->string('phone', 13); // no telepon customer
            $table->text('address'); // alamat customer
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at, untuk soft delete
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};