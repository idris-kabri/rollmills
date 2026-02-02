<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->double('total_delievery_charges')->default(0.0);
            $table->double('commission')->default(0.0);
            $table->string('remittance_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('total_delievery_charges');
            $table->dropColumn('commission');
            $table->dropColumn('remittance_at');
        });
    }
};
