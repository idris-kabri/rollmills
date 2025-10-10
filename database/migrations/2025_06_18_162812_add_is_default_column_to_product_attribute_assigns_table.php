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
        Schema::table('product_attribute_assigns', function (Blueprint $table) {
            $table->integer('is_default')->default(0)->after('title')->comment('0 = Off, 1 = On');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_attribute_assigns', function (Blueprint $table) {
            $table->dropColumn('is_default');
        });
    }
};
