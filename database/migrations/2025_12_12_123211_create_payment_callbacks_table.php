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
            $table->string('store_identifier');
            $table->string('invoice_number');
            $table->string('partner_transaction_no');
            $table->string('partner_reference_no');

            $table->date('transaction_date');
            $table->timestamp('transaction_time');
            
            $table->string('jenis_pembayaran');
            $table->text('qris_data');

            $table->bigInteger('amount');
            $table->bigInteger('nominal_mdr');
            $table->bigInteger('mdr_payment_amount');
            $table->integer('valid_time');

            $table->string('issuer_id');
            $table->string('retrieval_reference_no')->nullable();
            $table->string('payment_reference_no')->nullable();

            $table->string('payment_status');
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
