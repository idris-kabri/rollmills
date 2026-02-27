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
            $table->integer('status')->default(0)->comment('0 = Pending, 1 = Processed, 2 = Shipped, 3 = Complete, 4 = Cancelled, 5 = Return, 6 = Lost, 7 = OFD, 8 = Return Initianed, 9 = Undelivered, 10 = Rejected')->change();
            $table->longText('tracking_updates')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('status')->default(0)->comment('0 = Pending, 1 = Processed, 2 = Shipped, 3 = Complete, 4 = Cancelled, 5 = Return, 6 = Lost, 7 = OFD, 8 = Return Initianed, 9 = Undelivered, 10 = Rejected')->change();
            $table->dropColumn('tracking_updates');
        });
    }
};
