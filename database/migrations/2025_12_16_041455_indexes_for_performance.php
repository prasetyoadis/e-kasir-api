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
        //
        // transactions.created_at
        Schema::table('transactions', function (Blueprint $table) {
            $table->index('created_at', 'idx_transactions_created_at');
        });

        // payment_requests.external_id
        Schema::table('payment_requests', function (Blueprint $table) {
            $table->index('external_id', 'idx_payment_requests_external_id');
        });

        // inventory_logs.inventory_item_id
        Schema::table('inventory_logs', function (Blueprint $table) {
            $table->index('inventory_item_id', 'idx_inventory_logs_inventory_item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex('idx_transactions_created_at');
        });

        Schema::table('payment_requests', function (Blueprint $table) {
            $table->dropIndex('idx_payment_requests_external_id');
        });

        Schema::table('inventory_logs', function (Blueprint $table) {
            $table->dropIndex('idx_inventory_logs_inventory_item_id');
        });
    }
};
