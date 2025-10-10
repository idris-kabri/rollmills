<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRelation extends Model
{
    use SoftDeletes;

    protected $table = 'product_relations';

    protected $fillable = [
        'product_id',
        'related_product_id',
        'type',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id',"id");
    }

    public function relatedProduct()
    {
        return $this->belongsTo(Product::class, 'related_product_id',"id");
    }
}
