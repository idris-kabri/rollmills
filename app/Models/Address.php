<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = "addresses";
    protected $fillable = [
        "name",
        "email",
        "mobile",
        "address_line_1",
        "address_line_2",
        "city",
        "state",
        "zipcode",
        "ip_address",
        "is_user_logged_in_user",
        "user_id",
    ];

    public function getUser(){
        return $this->BelongsTo(User::class,"logged_in_user_id","id");
    }
}
