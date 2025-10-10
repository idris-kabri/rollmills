<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $table = "transactions";
    protected $fillable = [
        "user_id",
        "refrence_id",
        "refrence_table",
        "amount",
        "payment_id",
        "description",
        "status",
    ];

    public function getUser(){
        return $this->belongsTo(User::class,"user_id","id");
    }
}
