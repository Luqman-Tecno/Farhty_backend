<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeddingHall extends Model
{
    use HasFactory;

    protected $fillable = ['hall_name', 'capacity', 'latitude', 'longitude', 'city_id', 'shift_prices',
        'price_per_child', 'region', 'deposit_price', 'amenities', 'user_id', 'images'];

    protected $casts = [
        'shift_prices' => 'array',
        'images' => 'array',
    ];

    public function getShiftPrice($shift)
    {
        return $this->shift_prices[$shift] ?? null;
    }

    public function setShiftPrice($shift, $price)
    {
        $prices = $this->shift_prices;
        $prices[$shift] = $price;
        $this->shift_prices = $prices;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Services::class, 'wedding_hall_id');
    }
}
