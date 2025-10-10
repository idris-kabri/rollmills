<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use SoftDeletes;
    protected $table = "contact_us";
    protected $fillable = [
        "name",
        "email",
        "phone",
        "subject",
        "message",
        "user_id",
        "status"
    ];
}
