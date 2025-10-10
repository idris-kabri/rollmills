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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->string('image');
            $table->string('seo_title');
            $table->string('seo_description');
            $table->string('seo_meta');
            $table->boolean('is_featured')->default(0)->comment('0 = Off, 1 = On');
            $table->string('status')->default(1)->comment('0 = Draft, 1 = Published, 2 = Inactive'); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
