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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_logged_in_customer')->default(0);
            $table->unsignedBigInteger('user_id')->nullable();  
            $table->string('name');
            $table->string('email');
            $table->string('mobile_number');
            $table->text('images'); 
            $table->text('remarks');
            $table->tinyInteger('status')->default(0)->comment('0 = pending, 1 = converted, 2 = lost');
            $table->text('changed_remarks')->nullable();
            $table->timestamp('status_changed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
