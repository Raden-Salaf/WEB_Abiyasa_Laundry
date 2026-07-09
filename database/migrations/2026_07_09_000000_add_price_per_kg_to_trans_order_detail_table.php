<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('trans_order_detail', 'price_per_kg')) {
            Schema::table('trans_order_detail', function (Blueprint $table) {
                $table->integer('price_per_kg')->nullable()->after('id_service');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('trans_order_detail', 'price_per_kg')) {
            Schema::table('trans_order_detail', function (Blueprint $table) {
                $table->dropColumn('price_per_kg');
            });
        }
    }
};
