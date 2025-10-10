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
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('courier_id')->nullable();
            $table->string('courier')->nullable();
            $table->string('overall_rate')->nullable();
            $table->string('rate')->nullable();
            $table->string('shipping_margin_bear')->nullable();
            $table->string('etd')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['courier_id','courier','overall_rate','rate','shipping_margin_bear','etd']);
        });
    }
};
