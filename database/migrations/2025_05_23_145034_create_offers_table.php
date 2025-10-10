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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->dateTime("start_rage");
            $table->dateTime("end_rage");
            $table->integer("status")->default(1)->comment("0 = Pending, 1 = Active, 2 = Completed, 3 = Canceled");
            $table->integer("audience")->comment("1 = All, 2 = Registered Customer, 3 = Premium Customer, 4 = Standard");
            $table->string("discount_type")->comment("1 = Percentage, 2 = Amount");
            $table->string("discount_value");
            $table->string("image")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
