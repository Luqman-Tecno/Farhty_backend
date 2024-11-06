<?php

namespace App\Livewire;

use App\Models\WeddingHall;
use App\Service\BookingService;
use Carbon\Carbon;
use Livewire\Component;

abstract class BaseOfferDetails extends Component
{
    public $weddingHall;
    public $selectedDate;
    public $availableDates = [];
    public $showLoginModal = false;
    public $currentMonth;
    public $calendarDays = [];

    public function mount(WeddingHall $weddingHall)
    {
        $this->initializeWeddingHall($weddingHall);
        
        if ($this->weddingHall) {
            $bookingService = new BookingService();
            $this->availableDates = $bookingService->getAvailableDates($this->weddingHall);
            $this->currentMonth = now()->startOfMonth();
            $this->generateCalendarDays();
        }
    }

    protected function initializeWeddingHall(WeddingHall $weddingHall)
    {
        $this->weddingHall = $weddingHall;
    }

    public function generateCalendarDays()
    {
        if (!$this->weddingHall) {
            return;
        }

        $start = $this->currentMonth->copy()->startOfMonth()->startOfWeek();
        $end = $this->currentMonth->copy()->endOfMonth()->endOfWeek();
        
        $this->calendarDays = [];
        
        while ($start <= $end) {
            $date = $start->format('Y-m-d');
            $isCurrentMonth = $start->month === $this->currentMonth->month;
            
            if ($isCurrentMonth) {
                $availableDate = collect($this->availableDates)->firstWhere('date', $date);
                $this->calendarDays[] = [
                    'date' => $date,
                    'available' => $availableDate ? $availableDate['available'] : false,
                    'is_weekend' => in_array($start->dayOfWeek, [5, 6]),
                    'shifts' => $availableDate ? $availableDate['shifts'] : [],
                    'padding' => false,
                    'today' => $start->isToday(),
                    'past' => $start->isPast()
                ];
            } else {
                $this->calendarDays[] = [
                    'padding' => true
                ];
            }
            
            $start->addDay();
        }
    }

    public function nextMonth()
    {
        $this->currentMonth = Carbon::parse($this->currentMonth)->addMonth();
        $this->generateCalendarDays();
    }

    public function previousMonth()
    {
        $this->currentMonth = Carbon::parse($this->currentMonth)->subMonth();
        $this->generateCalendarDays();
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
    }

    public function proceedToBooking()
    {
        if (!auth()->check()) {
            $this->showLoginModal = true;
            return;
        }

        return redirect()->route('booking.form', [
            'weddingHall' => $this->weddingHall->id,
            'date' => $this->selectedDate
        ]);
    }

    abstract public function getPrice();
} 