<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meesho_orders', function (Blueprint $table) {
            $table->id();
            $table->string('sub_order_no');
            $table->string('status');
            $table->string('order_date');
            $table->string('customer_state');
            $table->string('product_name');
            $table->integer('gst');
            $table->string('sku');
            $table->integer('quantity');
            $table->double('price_per_piece');
            $table->double('total');
            $table->string('packet_qr');
            $table->string('remittance_at')->nullable();
            $table->string('transaction_id')->nullable();
            $table->double('remittance_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meesho_orders');
    }
};
