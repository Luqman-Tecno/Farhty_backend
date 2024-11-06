<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeddingHall extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hall_name',
        'capacity',
        'latitude',
        'longitude',
        'city_id',
        'region',
        'shift_prices',
        'deposit_price',
        'price_per_child',
        'amenities',
        'user_id',
        'images',
        'description',
        'status'
    ];

    protected $casts = [
        'shift_prices' => 'array',
        'amenities' => 'array',
        'images' => 'array',
        'status' => 'boolean'
    ];
    public function services(): HasMany
    {
        return $this->hasMany(Services::class);
    }

    public function offerSales(): HasMany
    {
        return $this->hasMany(OfferSale::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function getCurrentOffer()
    {
        return $this->offerSales()
            ->where('status', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
    }

    public function getOriginalPrice()
    {
        return $this->shift_prices['full_day'] ?? 0;
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
