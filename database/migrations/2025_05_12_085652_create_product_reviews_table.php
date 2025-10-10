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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger("product_id")->nullable();
            $table->unsignedBigInteger("user_id")->nullable(); 
            $table->string('name');
            $table->string('email');
            $table->string('image')->nullable();
            $table->integer("ratings");
            $table->longText("remarks"); 
            $table->integer('status')->default(1)->comment('1 =display, 0 = hide');
            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
