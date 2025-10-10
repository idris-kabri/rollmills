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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->longText("description");
            $table->integer("status")->default(1)->comment("0 = draft, 1 = publish, 2 = pending");
            $table->text("image");
            $table->integer("is_featured")->default(0)->comment("0 = off, 1 = on");
            $table->string("seo_title");
            $table->longText("seo_description");
            $table->string("seo_keyword");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
