<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
    protected $table = 'coupons';
    protected $fillable = ['title', 'image', 'coupon_code', 'minimum_order_value', 'discount_type', 'discount_value', 'maximum_discount_amount', 'usage_limit', 'total_usage', 'order_id', 'expiry_date', 'category', 'is_global', 'description'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'coupon_id', 'id');
    }
}
