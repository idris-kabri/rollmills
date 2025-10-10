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
        Schema::table('order_return_requests', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0)->comment('0 = pending, 1 = Accepted, 2 = Received, 3 = Approved, 4 = Reject')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_return_requests', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0)->comment('0 = pending, 1 = Approved, 2 = Reject')->change();
        });
    }
};
