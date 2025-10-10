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
        Schema::table('gift_card_groups', function (Blueprint $table) {
            $table->integer("is_custom")->default(0)->comment("default = 0 = no, 1 = yes");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gift_card_groups', function (Blueprint $table) {
            $table->dropColumn("is_custom");
        });
    }
};
