<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class OfferSale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'wedding_hall_id',
        'sale_price',
        'status',
        'start_date',
        'end_date',
        'description',
        'discount_percentage'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => 'boolean',
    ];

    public function weddingHall(): BelongsTo
    {
        return $this->belongsTo(WeddingHall::class);
    }

    public function calculateDiscountPercentage(): float
    {
        if (!$this->weddingHall) {
            return 0;
        }
        
        $originalPrice = $this->weddingHall->getOriginalPrice();
        if (!$originalPrice) {
            return 0;
        }
        
        return round((($originalPrice - $this->sale_price) / $originalPrice) * 100, 2);
    }

    public function getSavingAmount(): float
    {
        if (!$this->weddingHall) {
            return 0;
        }
        
        $originalPrice = $this->weddingHall->getOriginalPrice();
        return $originalPrice - $this->sale_price;
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }
}
