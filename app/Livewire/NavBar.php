<?php

namespace App\Livewire;

use App\Enum\BookingStatusEnum;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NavBar extends Component
{
    public $currentRoute;
    public $cartCount = 0;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];
    public $mobileMenuOpen = false;

    public function mount()
    {
        $this->updateCartCount();
        $this->currentRoute = request()->route()->getName();
    }

    public function updateCartCount()
    {
        if (Auth::check()) {

            $this->cartCount = Booking::where('user_id', auth()->user()->id)->where('status',BookingStatusEnum::Pending->value)->count();;
        }
    }

    public function toggleMobileMenu()
    {
        $this->mobileMenuOpen = !$this->mobileMenuOpen;
    }

    public function render()
    {
        return view('livewire.nav-bar');
    }
}
