<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;
    protected $table = "product_categories";
    protected $fillable = [
        "name",
        "description",
        "status",
        "image",
        "is_featured",
        "seo_title",
        "seo_description",
        "seo_keyword",
        'icon',
        'parent_id'
    ];

    public function getParentProductCategory(){
        return $this->belongsTo(ProductCategory::class, 'parent_id', 'id');
    }
    
    public function getProductCategoryAssign(){
        return $this->hasMany(ProductCategoryAssign::class, 'category_id', 'id');
    }
}
