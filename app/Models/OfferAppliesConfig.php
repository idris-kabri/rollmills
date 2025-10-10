<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferAppliesConfig extends Model
{
    use SoftDeletes;
    protected $table = "offer_applies_configs";
    protected $fillable = [
        'offer_id',
        'refrence_id',
        'min_qnty',
        'min_amount',
        'applies',
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
