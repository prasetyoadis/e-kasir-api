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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_num')->unique();
            $table->foreignUuid('created_by')->constrained('users');
            $table->foreignUuid('outlet_id');
            $table->string('costumer_name');
            $table->string('costumer_phone')->nullable();
            $table->string('costumer_address')->nullable();
            $table->decimal('subtotal', 25, 2)->default(0);
            $table->decimal('discount', 25, 2)->default(0);
            $table->decimal('tax', 25, 2)->default(0);
            $table->enum('payment_method', ['cash','qris','transfer','invoice'])->nullable();
            $table->enum('status', ['pending','paid','canceled','refunded'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
