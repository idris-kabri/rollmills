<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;
    protected $table = "banners";
    protected $fillable = [
        "image",
        "link",
        "heading",
        "sub_heading",
        "button_text",
        "status",
        "is_default",
        "start_time",
        "end_time", 
        "banner_type",
        'audience'
    ];
}
