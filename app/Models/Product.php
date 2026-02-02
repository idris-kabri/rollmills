<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    protected $fillable = ['name', 'slug', 'gst', 'description', 'youtube_video_link', 'images', 'featured_image', 'SKU', 'price', 'sale_price', 'sale_from_date', 'sale_to_date', 'out_of_stock', 'bulk_supported', 'weight', 'length', 'width', 'height', 'extra_shipping_margin', 'product_waranty', 'product_return_days', 'product_replacement_days', 'parent_id', 'specifications', 'seo_title', 'seo_meta', 'seo_description', 'pincode_excluded', 'status', 'is_featured', 'active_inactive_status', 'shipping_margin_br', 'gst'];

    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id');
    }

    public function getVarietion()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }

    public function categoryAssigns()
    {
        return $this->hasMany(ProductCategoryAssign::class, 'product_id');
    }
    public function attributeAssigns()
    {
        return $this->hasMany(ProductAttributeAssign::class, 'product_id');
    }
    public function brands()
    {
        return $this->hasMany(ProductBrand::class, 'product_id');
    }
    public function productRelation()
    {
        return $this->hasMany(ProductRelation::class, 'product_id');
    }
}
