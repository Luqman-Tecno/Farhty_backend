<?php

namespace App\Livewire;

use App\Models\Booking;
use Livewire\Component;
use App\Enum\BookingStatusEnum;

class BookingShow extends Component
{
    public $booking;
    public $statusColors = [
        'Pending' => 'yellow',
        'Booked' => 'green',
        'Cancelled' => 'red',
        'Checkout' => 'blue'
    ];

    public function mount(Booking $booking)
    {
        $this->booking = $booking->load(['weddingHall.city']);
    }

    public function cancelBooking()
    {
        if ($this->booking->status === BookingStatusEnum::Pending->value) {
            $this->booking->update(['status' => BookingStatusEnum::Cancelled->value]);
            session()->flash('message', 'تم إلغاء الحجز بنجاح');
            return redirect()->route('bookings.show', $this->booking);
        } else {
            session()->flash('error', 'لا يمكن إلغاء هذا الحجز في وضعه الحالي');
        }
    }

    public function getStatusColorClass()
    {
        return match($this->booking->status) {
            BookingStatusEnum::Pending->value => 'bg-yellow-100 text-yellow-800',
            BookingStatusEnum::Booked->value => 'bg-green-100 text-green-800',
            BookingStatusEnum::Cancelled->value => 'bg-red-100 text-red-800',
            BookingStatusEnum::CHECKOUT->value => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }


    public function render()
    {
        return view('bookings.show')->layout('layouts.app');
    }
}
