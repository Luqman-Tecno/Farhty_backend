<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\WeddingHall;
use Livewire\Component;

class Offers extends Component
{
    public $cityId = '';
    public $region = '';
    public $capacity = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $hasActiveOffers = false;

    public function mount($city = null)
    {
        if ($city) {
            $this->cityId = $city;
        }
    }

    public function render()
    {
        $halls = WeddingHall::query()
            ->active()
            ->when($this->cityId, function ($query) {
                return $query->where('city_id', $this->cityId);
            })
            ->when($this->region, function ($query) {
                return $query->where('region', 'like', '%' . $this->region . '%');
            })
            ->when($this->capacity, function ($query) {
                return $query->where('capacity', '>=', $this->capacity);
            })
            ->when($this->hasActiveOffers, function ($query) {
                return $query->withActiveOffers();
            })
            ->when($this->sortField === 'shift_prices', function ($query) {
                return $query->orderByRaw("CAST(JSON_EXTRACT(shift_prices, '$.full_day') AS DECIMAL) {$this->sortDirection}");
            })
            ->when($this->sortField === 'capacity', function ($query) {
                return $query->orderBy('capacity', $this->sortDirection);
            })
            ->with(['city', 'offerSales' => function($query) {
                $query->active();
            }])
            ->get();

        return view('livewire.offers', [
            'cities' => City::all(),
            'halls' => $halls
        ])->layout('layouts.app');
    }

    public function sortByPrice()
    {
        if ($this->sortField === 'shift_prices' && $this->sortDirection === 'asc') {
            $this->sortDirection = 'desc';
        } else {
            $this->sortField = 'shift_prices';
            $this->sortDirection = 'asc';
        }
    }

    public function sortByCapacity()
    {
        if ($this->sortField === 'capacity' && $this->sortDirection === 'asc') {
            $this->sortDirection = 'desc';
        } else {
            $this->sortField = 'capacity';
            $this->sortDirection = 'asc';
        }
    }
}
