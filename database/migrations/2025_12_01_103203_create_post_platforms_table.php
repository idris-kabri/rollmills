<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_platforms', function (Blueprint $table) {
            $table->id();
            $table->string('post_id');
            $table->string('keyword');
            $table->string('message');
            $table->string('number_of_comment');
            $table->string('product_id');
            $table->string('platform');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_platforms');
    }
};
