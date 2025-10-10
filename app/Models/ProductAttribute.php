<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttribute extends Model
{
    use SoftDeletes;

    protected $table = 'product_attributes';

    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public function getAttibuteItems(){
        return $this->hasMany(ProductAttributesItem::class, 'product_attribute_id', 'id');
    }
}
