<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiftCardItem extends Model
{
    use SoftDeletes; 
    protected $table = 'gift_card_items'; 
    protected $fillable = [
        'title', 
        'gift_code', 
        'created_by', 
        'gift_card_group_id', 
        'user_id', 
        'customer_name', 
        'customer_email', 
        'used_at', 
        'is_gift_item'
    ]; 

    public function fetchCreatedBy(){ 
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function getGiftCardGroupId(){ 
        return $this->belongsTo(GiftCardGroup::class,'gift_card_group_id','id');
    }
}
