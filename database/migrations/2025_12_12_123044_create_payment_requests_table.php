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
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('transaction_id');
            $table->foreignUlid('payment_method_id');
            $table->bigInteger('amount');
            $table->enum('status', ['PENDING','WAITING','PAID','FAILED','EXPIRED']);
            $table->string('external_id')->nullable();
            $table->string('external_payment_url')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_requests');
    }
};
