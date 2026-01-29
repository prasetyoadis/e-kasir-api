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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('product_id')->references('id')->on('products');
            $table->string('variant_name');
            $table->text('description')->nullable();
            $table->bigInteger('price')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_variant')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
