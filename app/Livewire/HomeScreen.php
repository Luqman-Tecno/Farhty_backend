<?php

namespace App\Livewire;

use App\Models\City;
use Livewire\Component;

class HomeScreen extends Component
{

    public $city = null;

    public function mount()
    {
        $this->city = City::all();

    }

    public function render()
    {
        return view('livewire.home-screen')->layout('layouts.app');
    }
}
