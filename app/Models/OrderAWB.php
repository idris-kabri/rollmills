<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAWB extends Model
{
    protected $table = 'order_awb';

    protected $fillable = ['order_id', 'aggregator', 'provider', 'awb_number', 'charges_taken', 'remarks', 'cod_charges'];

    public function getOrder()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
