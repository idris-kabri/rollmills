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
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('billing_address_id')->after('additional_information');
            $table->integer('ship_different_address_id')->after('billing_address_id');
            $table->integer('gift_card_item_id')->after('ship_different_address_id')->nullable();
            $table->integer('gift_card_discount')->after('gift_card_item_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['billing_address_id','ship_different_address_id','gift_card_item_id','gift_card_discount']);
        });
    }
};
