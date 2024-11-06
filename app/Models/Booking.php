<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wedding_hall_id',
        'booking_date',
        'start_time',
        'end_time',
        'shift',
        'deposit_cost',
        'total_cost',
        'deposit_paid',
        'children_count',
        'status',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'deposit_paid' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function weddingHall(): BelongsTo
    {
        return $this->belongsTo(WeddingHall::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
