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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->longText("description");
            $table->longText("short_description")->nullable();
            $table->string("youtube_video_link")->nullable();
            $table->longText("images");
            $table->longText("featured_image");
            $table->string("SKU")->nullable();
            $table->double("price");
            $table->double("sale_price")->nullable();
            $table->date("sale_from_date")->nullable();
            $table->date("sale_to_date")->nullable();
            $table->integer("out_of_stock")->comment("0 = No, 1 = Yes");
            $table->integer("bulk_supported")->comment("0 = No, 1 = Yes");
            $table->string("weight");
            $table->string("length");
            $table->string("width");
            $table->string("height");
            $table->string("extra_shipping_margin");
            $table->string("product_waranty");
            $table->string("product_return_days");
            $table->string("product_replacement_days");
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->longText("specifications")->nullable();
            $table->string("seo_title")->nullable();
            $table->string("seo_meta")->nullable();
            $table->longText("seo_description")->nullable();
            $table->string("pincode_excluded")->nullable();
            $table->integer("status")->default(1)->comment("0 = draft, 1 = published");
            $table->integer("is_featured")->default(0)->comment("0 = No, 1 = Yes");
            $table->timestamps();
            $table->softDeletes();
            $table->foreign("parent_id")->references("id")->on("products")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
