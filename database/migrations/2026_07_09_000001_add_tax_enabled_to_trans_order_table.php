<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('trans_order', 'tax_enabled')) {
            Schema::table('trans_order', function (Blueprint $table) {
                $table->boolean('tax_enabled')->default(true)->after('total');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('trans_order', 'tax_enabled')) {
            Schema::table('trans_order', function (Blueprint $table) {
                $table->dropColumn('tax_enabled');
            });
        }
    }
};
