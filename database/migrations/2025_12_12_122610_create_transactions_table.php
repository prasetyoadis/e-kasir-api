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
            $table->ulid('id')->primary();
            $table->string('order_num')->unique();
            $table->foreignUuid('created_by')->constrained('users');
            $table->foreignUlid('outlet_id');
            $table->string('customer_name');
            $table->bigInteger('discount')->default(0);
            $table->bigInteger('tax')->default(0);
            $table->bigInteger('subtotal')->default(0);
            $table->enum('payment_method', ['cash','qris','transfer','invoice'])->nullable();
            $table->enum('status', ['DRAFT', 'PENDING','PAID','COMPLATE','CANCELED','REFUNDED'])->default('DRAFT');
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
