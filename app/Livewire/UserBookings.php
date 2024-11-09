<?php

namespace App\Livewire;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserBookings extends Component
{
    public $bookings;

    public function mount()
    {
        $this->loadBookings();
    }

    public function loadBookings()
    {
        // Fetch bookings for the authenticated user
        $this->bookings = Booking::with('weddingHall')
            ->where('user_id', auth()->user()->id)
            ->orderBy('booking_date', 'desc')
            ->get();

      
    }

    public function render()
    {
        return view('livewire.user-bookings')->layout('layouts.app');
    }
}
