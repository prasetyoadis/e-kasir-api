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
        Schema::create('outlets', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUuid('owner_id')->constrained('users');
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('msisdn')->nullable();
            $table->enum('type', ['fnb', 'retail', 'service', 'pharmacy', 'market']);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('outlet_subscription', function (Blueprint $table) {
            $table->foreignUlid('subscription_id');
            $table->foreignUlid('outlet_id');
            $table->timestamps();
        });

        Schema::create('outlet_user', function (Blueprint $table) {
            $table->foreignUuid('employee_id')->constrained('users');
            $table->foreignUlid('outlet_id');
            $table->foreignUlid('role_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlet_subscription');
        Schema::dropIfExists('outlets');
    }
};
