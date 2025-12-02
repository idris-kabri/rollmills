<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbendedCartMessage extends Model
{
    protected $table = 'abended_cart_messages';

    protected $fillable = [
        'mobile_number',
        'send_at',
    ];
}
