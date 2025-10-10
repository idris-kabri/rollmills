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
        Schema::create('offer_applies_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("offer_id");
            $table->string("refrence_id")->nullable();
            $table->string("min_qnty")->nullable();
            $table->string("min_amount")->nullable();
            $table->integer("applies")->comment("1 = Product, 2 = Brand, 3 = Category, 4 = Least Price");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_applies_configs');
    }
};
