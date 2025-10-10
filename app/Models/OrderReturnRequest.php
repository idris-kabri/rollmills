<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderReturnRequest extends Model
{
    use SoftDeletes;
    protected $table = 'order_return_requests';
    protected $fillable = [
        'order_id',
        'order_item_id',
        'customer_id',
        'changed_by',
        'changed_at',
        'reason',
        'remarks',
        'images',
        'changed_remarks',
        'status',
    ]; 

    public function fetchCustomer(){ 
        return $this->belongsTo(User::class,'customer_id','id');
    }

    public function fetchOrderItem(){ 
        return $this->belongsTo(OrderItems::class,'order_item_id','id');
    }

    public function fetchOrder(){ 
        return $this->belongsTo(Order::class,'order_id','id');
    }
}
