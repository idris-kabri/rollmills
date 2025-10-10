<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomPasswordResetToken extends Model
{
    use SoftDeletes;
    protected $table = "custom_password_reset_tokens";
    protected $fillable = [
        "customer_id",
        "customer_email",
        "token",
        "new_password",
        "status",
    ];
    public function getCustomer(){
        return $this->belongsTo(User::class,"customer_id");
    }
}
