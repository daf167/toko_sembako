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
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('item_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['masuk', 'keluar']);
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('stock_before')->nullable();
            $table->unsignedInteger('stock_after')->nullable();
            $table->date('date');
            $table->string('item_code_snapshot')->nullable();
            $table->string('item_name_snapshot')->nullable();
            $table->string('category_name_snapshot')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};
