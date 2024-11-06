<?php

namespace App\Livewire;

class OfferDetails extends BaseOfferDetails
{
    protected function initializeWeddingHall($weddingHall)
    {
        $this->weddingHall = $weddingHall;
    }

    public function getPrice()
    {
        return $this->weddingHall->shift_prices['full_day'] ?? 0;
    }

    public function render()
    {
        return view('livewire.offer-details')->layout('layouts.app');
    }
}
