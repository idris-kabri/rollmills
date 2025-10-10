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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email");
            $table->string("mobile");
            $table->text("address_line_1");
            $table->text("address_line_2")->nullable();
            $table->string("city");
            $table->string("state");
            $table->string("zipcode");
            $table->string("ip_address")->nullable();
            $table->integer("is_user_logged_in_user")->nullable()->comment("0 = No, 1 = Yes");
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
