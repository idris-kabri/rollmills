<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttributeAssign extends Model
{
    use SoftDeletes;

    protected $table = 'product_attribute_assigns';
    protected $fillable = [
        'product_id',
        'product_set_id',
        'title', 
        'is_default'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id',"id");
    }

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_set_id',"id");
    }
}
