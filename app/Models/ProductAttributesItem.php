<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttributesItem extends Model
{
    use SoftDeletes;

    protected $table = 'product_attributes_items';

    protected $fillable = [
        'product_attribute_id',
        'name',
        'is_default',
        'description',
        'status'
    ];

    public function getProductAttribute(){
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id', 'id');
    }
}
