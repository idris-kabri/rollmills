<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Model
{
    use SoftDeletes;
    protected $table = "product_reviews";
    protected $fillable = [
        'product_id',
        'user_id',
        'name',
        'email',
        'image',
        'ratings',
        'remarks',
        'status',
    ]; 
    
    public function getProducts(){
        return $this->belongsTo(Product::class,"product_id");
    }

    public function getUsers(){
        return $this->belongsTo(Product::class,"user_id");
    }
}
