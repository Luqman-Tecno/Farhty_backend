<?php

namespace App\Livewire;

use App\Models\WeddingHall;

use App\Service\BookingService;
use Livewire\Component;

class OfferDetails extends Component
{
    public $weddingHall;
    public $selectedDate;
    public $selectedShift = 'evening'; // Default shift
    public $showLoginModal = false;

    public function mount(WeddingHall $weddingHall)
    {
        $this->weddingHall = $weddingHall;
        $this->selectedDate = now()->format('Y-m-d');
    }

    public function checkAvailability()
    {
        if (!auth()->check()) {
            $this->showLoginModal = true;
            return;
        }

        $bookingService = new BookingService();

        $avilabel = $bookingService->isShiftAvailable($this->weddingHall, $this->selectedDate, $this->selectedShift);
        if (!$avilabel) {
            session()->flash('error', 'هذي الموعد غير متاح');
        } else {
            return redirect()->route('booking.form', [
                'weddingHall' => $this->weddingHall
            ]);
        }
        // Here you can add logic to check if the date and shift are available
        // and redirect to booking page or show booking form

    }


    public function render()
    {
        return view('livewire.offer-details')->layout('layouts.app');
    }
}
