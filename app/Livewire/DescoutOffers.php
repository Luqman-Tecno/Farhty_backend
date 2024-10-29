<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\WeddingHall;
use Livewire\Component;

class DescoutOffers extends Component
{
    public $priceRange = '';
    public $capacity = '';
    public $cityId = '';
    public $region = '';
    public $cities; // Make sure this is public
    public $offers;

    public $sortField = 'shift_prices';
    public $sortDirection = 'asc';

    public function mount()
    {
        // Initialize the properties
        $this->cities = City::all();
        $this->halls = collect(); // Initialize as empty collection
        $this->loadWeddingHalls();
    }

    private function loadWeddingHalls()
    {
        $this->halls = WeddingHall::query()
            ->when($this->capacity, function ($query) {
                return $query->where('capacity', '>=', $this->capacity);
            })
            ->when($this->cityId, function ($query) {
                return $query->where('city_id', $this->cityId);
            })
            ->when($this->region, function ($query) {
                return $query->where('region', $this->region);
            })
            ->with(['city', 'user', 'services'])
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();
    }

    public function sortByPrice()
    {
        $this->sortField = 'shift_prices';
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        $this->loadWeddingHalls();
    }

    public function sortByCapacity()
    {
        $this->sortField = 'capacity';
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        $this->loadWeddingHalls();
    }

    public function updatedCityId()
    {
        $this->loadWeddingHalls();
    }

    public function updatedRegion()
    {
        $this->loadWeddingHalls();
    }

    public function updatedCapacity()
    {
        $this->loadWeddingHalls();
    }

    public function updatedPriceRange()
    {
        $this->loadWeddingHalls();
    }

    public function render()
    {
        return view('livewire.descout-offers')->layout('layouts.app');
    }
}
