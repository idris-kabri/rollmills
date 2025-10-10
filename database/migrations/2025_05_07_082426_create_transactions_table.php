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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->string("refrence_id");
            $table->string("refrence_table");
            $table->string("amount");
            $table->string("payment_id");
            $table->text("description");
            $table->integer("status")->default(0)->comment("0 = Pending, 1 = Confirm, 2 = Cancel");
            $table->timestamps();
            $table->softDeletes();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
