<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostPlatform extends Model
{
    protected $table = 'post_platforms';
    protected $fillable = [
        'post_id',
        'keyword',
        'message',
        'number_of_comment',
        'product_id',
        'platform',
    ];

    public function getProduct()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
