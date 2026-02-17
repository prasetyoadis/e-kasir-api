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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUuid('user_id');
            $table->integer('subscription_type');
            $table->enum('subscription_status', ['active','pending','inactive']);
            $table->timestamp('valid_from');
            $table->timestamp('valid_to');
            $table->integer('ppn_percent');
            $table->integer('service_percent');
            $table->timestamps();
        });

        Schema::create('subscription_user', function (Blueprint $table) {
            $table->foreignUlid('subscription_id');
            $table->foreignUuid('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_user');
        Schema::dropIfExists('subscriptions');
    }
};
