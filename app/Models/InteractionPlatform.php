<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InteractionPlatform extends Model
{
    protected $table = 'interaction_platforms';
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'image',
        'type',
        'post_id',
        'description',
    ];
}
