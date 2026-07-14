<?php

// database/migrations/2024_01_01_000001_create_sales_tables.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->string('customer_name');
            $table->decimal('total_price', 15, 2);
            $table->foreignId('user_id')->constrained(); // Kasir yang melayani
            $table->timestamps();
        });

        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->string('item_name');
            $table->enum('machine', ['outdoor', 'indoor', 'ricoh', 'riso', 'cardpresso', 'sablon', 'cutting']);
            $table->integer('qty');
            $table->decimal('price', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->enum('status', ['pending', 'proses', 'selesai'])->default('pending');
            $table->string('file_path')->nullable(); // Link file desain
            $table->text('notes')->nullable(); // Detail finishing (mata ayam, laminasi, dll)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('sales');
    }
};
