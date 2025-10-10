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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer("is_logged_in_user")->comment("0 = No, 1 = Yes");
            $table->unsignedBigInteger("logged_in_user_id")->nullable();
            $table->string("subtotal")->nullable();
            $table->string("coupon_discount")->default(0);
            $table->string("coupon_id")->nullable();
            $table->string("offer_discount")->default(0);
            $table->string("shipping_charges")->default(0);
            $table->string("shipping_bearable")->default(0);
            $table->string("total");
            $table->integer("status")->default(0)->comment("0 = Pending, 1 = Processed, 2 = Shipped, 3 = Complete");
            $table->integer("is_manual_pickup")->comment("0 = No, 1 = Yes");
            $table->string("paid_amount");
            $table->string("remaining_amount")->default(0);
            $table->integer("is_cod")->nullable()->comment("0 = No, 1 = Yes");
            $table->unsignedBigInteger("address_id");
            $table->timestamps();
            $table->foreign("logged_in_user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("address_id")->references("id")->on("addresses")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
