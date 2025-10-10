<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferTriggerConfig extends Model
{
    use SoftDeletes;
    protected $table = "offer_trigger_configs";
    protected $fillable = [
        'offer_id',
        'refrence_id',
        'min_qnty',
        'min_amount',
        'trigger_type',
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
