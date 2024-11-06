<?php

namespace App\Livewire;

use App\Models\WeddingHall;
use Livewire\Component;

class OfferSale extends Component
{
    public $halls = [];

    public function mount()
    {
        $this->halls = WeddingHall::query()
            ->active()
            ->with(['city', 'offerSales' => function($query) {
                $query->active();
            }])
            ->whereHas('offerSales', function($query) {
                $query->active();
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.offer-sale', [
            'halls' => $this->halls
        ])->layout('layouts.app');
    }
}
