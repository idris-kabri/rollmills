<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiftCardGroup extends Model
{
    use SoftDeletes; 
    protected $table = 'gift_card_groups';
    protected $fillable = [
        'price',
        'show_customer',
        'is_custom',
        'status',
    ]; 

    public function giftCardItems(){ 
        return $this->hasMany(GiftCardItem::class,'gift_card_group_id','id');
    }
}
