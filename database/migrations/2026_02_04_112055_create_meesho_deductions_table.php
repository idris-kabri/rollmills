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
        Schema::create('meesho_deductions', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('campaign_id');
            $table->double('sub_total');
            $table->double('discount');
            $table->integer('gst');
            $table->double('total_sum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meesho_deductions');
    }
};
