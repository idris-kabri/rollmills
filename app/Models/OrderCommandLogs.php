<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCommandLogs extends Model
{
    protected $table = 'order_command_logs';

    protected $fillable = ['order_id', 'command_for', 'response', 'request_body', 'api_response'];

    public function getOrder()
    {
        return $this->belongsTo(Order::class);
    }
}
