<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'wedding_hall_id',
        'payment_date',
        'amount',
        'payment_method',
        'payment_type',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function weddingHall(): BelongsTo
    {
        return $this->belongsTo(WeddingHall::class);
    }
}
