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
        Schema::create('permissions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignUlid('permission_id');
            $table->foreignUlid('role_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
    }
};
