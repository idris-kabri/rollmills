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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id");
            $table->string("item_id");
            $table->string("quantity");
            $table->string("regular_price");
            $table->string("sale_default_price")->default(0);
            $table->string("sale_price")->default(0);
            $table->date("sale_price_start_date")->nullable();
            $table->date("sale_price_end_date")->nullable();
            $table->string("subtotal");
            $table->string("offer_discount");
            $table->unsignedBigInteger("offer_id")->nullable();
            $table->string("total");
            $table->timestamps();
            $table->foreign("order_id")->references("id")->on("orders")->onDelete("cascade");
            $table->foreign("offer_id")->references("id")->on("offers")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
