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
        Schema::create('gift_card_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('price')->unique();
            $table->integer('show_customer')->comment('0 => no, 1 => yes')->default(0);
            $table->integer('status')->comment('0 => inactive, 1 => active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_card_groups');
    }
};
