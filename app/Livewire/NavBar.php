<?php

namespace App\Livewire;

use Livewire\Component;

class NavBar extends Component
{
    public $currentRoute;

    public function mount()
    {
        $this->currentRoute = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.nav-bar');
    }
}
