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
            $table->foreignUuid('created_by');
            $table->foreignUlid('outlet_id');
            $table->string('customer_name')->nullable();
            $table->bigInteger('subtotal')->default(0);
            $table->bigInteger('item_discount_total')->default(0);
            $table->bigInteger('global_discount_total')->default(0);
            $table->bigInteger('net_amount')->default(0);
            $table->integer('tax_percent_total')->default(0);
            $table->bigInteger('tax_amount')->default(0);
            $table->enum('payment_method', ['cash','qris','card'])->nullable();
            $table->enum('status', ['DRAFT', 'PENDING','PAID', 'COMPLETED', 'CANCELED','REFUNDED'])->default('DRAFT');
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
