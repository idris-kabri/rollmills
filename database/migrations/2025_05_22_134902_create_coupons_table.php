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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->text("image");
            $table->string("coupon_code",191)->unique();
            $table->string("minimum_order_value");
            $table->enum("discount_type",["Percentage","Amount"]);
            $table->string("discount_value");
            $table->string("maximum_discount_amount");
            $table->integer("usage_limit");
            $table->integer("total_usage")->default(0);
            $table->string("expiry_date");
            $table->text("category");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
