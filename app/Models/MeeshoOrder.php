<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeeshoOrder extends Model
{
    protected $table = 'meesho_orders';
    protected $fillable = ['sub_order_no', 'status', 'order_date', 'customer_state', 'product_name', 'gst', 'sku', 'quantity', 'price_per_piece', 'total', 'packet_qr', 'remittance_at', 'transaction_id', 'remittance_amount'];
    protected $casts = [
        'order_date' => 'datetime',
        'remittance_amount' => 'double',
        'total' => 'double',
    ];
}
