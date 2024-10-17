<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Services extends Model
{
    protected $fillable = [
        'name',
        'price',
        'wedding_hall_id',
    ];

    public function weddingHall(): BelongsTo
    {
        return $this->belongsTo(WeddingHall::class);
    }
}
