<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use SoftDeletes; 
    protected $table = 'quotations'; 
     protected $fillable = [
        'is_logged_in_customer',
        'user_id',
        'name',
        'email',
        'mobile_number',
        'images',
        'remarks',
        'status',
        'changed_remarks',
        'status_changed_at',
    ];
}
