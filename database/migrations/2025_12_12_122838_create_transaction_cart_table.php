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
        Schema::create('transaction_cart', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('transaction_id');
            $table->integer('quantity')->nullable();
            $table->bigInteger('total');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('transaction_cart_item', function (Blueprint $table) {
            $table->foreignUlid('transaction_cart_id')->references('id')->on('transaction_cart');
            $table->foreignUlid('transaction_item_id');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_cart_item');
        Schema::dropIfExists('transaction_cart');
    }
};
