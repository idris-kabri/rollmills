<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategoryAssign extends Model
{
    use SoftDeletes;

    protected $table = 'product_category_assigns';

    protected $fillable = [
        'product_id',
        'category_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id',"id");
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id',"id");
    }
}
