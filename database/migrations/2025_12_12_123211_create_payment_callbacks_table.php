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
        Schema::create('payment_callbacks', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('payment_request_id');
            $table->json('raw_payload');
            $table->string('status');
            $table->enum('source', ['gateway', 'system', 'admin']);
            $table->foreignUuid('created_by')->nullable()->constrained('users');
            $table->timestamp('callback_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_callbacks');
    }
};
