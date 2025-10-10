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
        Schema::create('offer_trigger_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("offer_id");
            $table->string("refrence_id");
            $table->string("min_qnty")->nullable();
            $table->string("min_amount")->nullable();
            $table->integer("trigger_type")->comment("1 = Product, 2 = Brand, 3 = Category");
            $table->timestamps();
            $table->foreign("offer_id")->references("id")->on("offers")->onDelete("cascade");
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_trigger_configs');
    }
};
