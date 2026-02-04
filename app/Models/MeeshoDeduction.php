<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeeshoDeduction extends Model
{
    protected $table = 'meesho_deductions';
    protected $fillable = ['date', 'campaign_id', 'sub_total', 'discount', 'gst', 'total_sum'];
    protected $casts = [
        'date' => 'date',
        'sub_total' => 'double',
        'discount' => 'double',
        'total_sum' => 'double',
        'gst' => 'integer',
    ];
}
