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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->text("image");
            $table->text("link")->nullable();
            $table->text("heading");
            $table->text("sub_heading");
            $table->string("button_text");
            $table->integer("status")->default(1)->comment("0 = inactive, 1 = active");
            $table->integer("is_default")->default(0)->comment("0 = not default, 1 = default");
            $table->date("start_time");
            $table->date("end_time");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
