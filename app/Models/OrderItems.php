<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $table = "order_items";
    protected $fillable = [
        "order_id",
        "item_id",
        "quantity",
        "regular_price",
        "sale_default_price",
        "sale_price",
        "sale_price_start_date",
        "sale_price_end_date",
        "subtotal",
        "offer_discount",
        "offer_id",
        "total", 
        'item_return_days', 
        'item_replacement_days',
        "courier_id",
        'courier',
        'overall_rate',
        'rate',
        'shipping_margin_bear',
        'etd', 
        'status', 
        'delivery_at'
    ];

    public function getOrder(){
        return $this->BelongsTo(Order::class,"order_id","id");
    }
    public function getProduct(){ 
        return $this->belongsTo(Product::class,'item_id','id');
    }
    public function getOffer(){
        return $this->BelongsTo(Offer::class,"offer_id","id");
    } 
    public function OrderRetun() {
       return $this->hasOne(OrderReturnRequest::class, 'order_item_id');
    }
}
