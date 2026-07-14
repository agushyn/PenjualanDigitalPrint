<?php

// database/migrations/2026_07_12_000003_add_discount_to_sales_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('discount', 15, 2)->default(0)->after('total_price');
            $table->decimal('grand_total', 15, 2)->default(0)->after('discount'); // Total akhir setelah diskon
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['discount', 'grand_total']);
        });
    }
};
