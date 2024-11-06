<?php

namespace App\Livewire;

use App\Models\City;
use Livewire\Component;

class HomeScreen extends Component
{

    public $cities;

    public function mount()
    {
        $this->cities = City::withCount('weddingHalls')
            ->has('weddingHalls')
            ->orderBy('wedding_halls_count', 'desc')
            ->take(4)
            ->get();
    }

    public function redirectToOffers($cityId)
    {
        return redirect()->route('offers', ['city' => $cityId]);
    }

    public function render()
    {
        return view('livewire.home-screen')->layout('layouts.app');
    }
}
