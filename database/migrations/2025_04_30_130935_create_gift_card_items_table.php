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
        Schema::create('gift_card_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gift_card_group_id')->references('id')->on('gift_card_groups')->onDelete('cascade'); 
            $table->string('title');
            $table->string('gift_code',191)->unique(); 
            $table->integer('created_by'); 
            $table->integer('user_id')->nullable(); 
            $table->dateTime('used_at')->nullable(); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_card_items');
    }
};
