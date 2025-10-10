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
        Schema::create('custom_password_reset_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("customer_id")->nullable();
            $table->string("customer_email");
            $table->longText("token");
            $table->string("new_password")->nullable();
            $table->string("status")->default(0)->comment("0 = not confirmed, 1 = confirm, 2 = Cancel");
            $table->timestamps();
            $table->foreign("customer_id")->references("id")->on("users")->onDelete("cascade");
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_password_reset_tokens');
    }
};
