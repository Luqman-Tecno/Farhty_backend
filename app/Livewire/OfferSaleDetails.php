<?php

namespace App\Livewire;

use App\Models\WeddingHall;

class OfferSaleDetails extends BaseOfferDetails
{
    protected function initializeWeddingHall($weddingHall)
    {
        $this->weddingHall = WeddingHall::query()
            ->with(['city', 'offerSales' => function($query) {
                $query->active();
            }])
            ->where('id', $weddingHall->id)
            ->active()
            ->whereHas('offerSales', function($query) {
                $query->active();
            })
            ->first();
    }

    public function getPrice()
    {
        if (!$this->weddingHall) {
            return 0;
        }
        
        $currentOffer = $this->weddingHall->getCurrentOffer();
        return $currentOffer ? $currentOffer->sale_price : $this->weddingHall->getOriginalPrice();
    }

    public function getDiscountPercentage()
    {
        if (!$this->weddingHall) {
            return 0;
        }

        $currentOffer = $this->weddingHall->getCurrentOffer();
        return $currentOffer ? $currentOffer->calculateDiscountPercentage() : 0;
    }

    public function getSavingAmount()
    {
        if (!$this->weddingHall) {
            return 0;
        }

        $currentOffer = $this->weddingHall->getCurrentOffer();
        return $currentOffer ? $currentOffer->getSavingAmount() : 0;
    }

    public function render()
    {
        return view('livewire.offer-sale-details', [
            'currentOffer' => $this->weddingHall?->getCurrentOffer(),
            'originalPrice' => $this->weddingHall?->getOriginalPrice() ?? 0,
            'discountedPrice' => $this->getPrice(),
            'discountPercentage' => $this->getDiscountPercentage(),
            'savingAmount' => $this->getSavingAmount(),
        ])->layout('layouts.app');
    }
}
