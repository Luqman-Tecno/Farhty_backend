<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\WeddingHall;
use App\Enum\BookingShiftEnum;
use App\Service\BookingService;
use Carbon\Carbon;
use function PHPUnit\Framework\isInstanceOf;

class BookingForm extends Component
{
    public $weddingHall;
    public $bookingDate;
    public $shift;
    public $childrenCount = 0;
    public $notes;
    public $specialRequests;
    public $additionalServices = [];
    public $schedule = [];
    public $priceBreakdown = [];


    protected $rules = [
        'bookingDate' => 'required|date|after:today',
        'shift' => 'required|in:day,night,full_day',  // List the actual enum values
        'childrenCount' => 'nullable|integer|min:0',
        'notes' => 'nullable|string',
        'specialRequests' => 'nullable|string',
        'additionalServices' => 'array'
    ];

    public function mount(WeddingHall $weddingHall)
    {

        $this->weddingHall = $weddingHall;
        $this->loadSchedule();
    }

    public function loadSchedule()
    {
        $bookingService = new BookingService();
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addWeek();
        $this->schedule = $bookingService->getAvailableShiftsForHall($this->weddingHall, $startDate, $endDate);
    }

    public function updatedBookingDate()
    {
        $this->calculatePrice();
    }

    public function updatedShift()
    {
        $this->calculatePrice();
    }

    public function updatedChildrenCount()
    {
        $this->calculatePrice();
    }

    public function updatedAdditionalServices()
    {
        $this->calculatePrice();
    }

    public function calculatePrice()
    {
        if ($this->bookingDate && $this->shift) {
            $bookingService = new BookingService();


            $this->priceBreakdown = self::calculatePrices();
        }
    }

    public function calculatePrices()
    {
        $childrenCost = $this->weddingHall->price_per_child * $this->childrenCount;
        $basePrice = $this->weddingHall->getShiftPrice($this->shift);
        $servicesCost = 0; // Calculate services cost
        $tax = ($basePrice + $childrenCost + $servicesCost) * 0.15; // Assuming 15% tax
        $totalPrice = $basePrice + $childrenCost + $servicesCost + $tax;
        $depositRequired = $this->weddingHall->deposit_price; // Assuming 20% deposit

        return [
            'base_price' => $basePrice,
            'children_cost' => $childrenCost,
            'services_cost' => $servicesCost,
            'tax' => $tax,
            'total_cost' => $totalPrice,
            'deposit_required' => $depositRequired
        ];
    }

    public function submit()
    {
        try {
            $validatedData = $this->validate();

            $bookingData = [
                'booking_date' => $this->bookingDate,
                'shift' => $this->shift,
                'children_count' => $this->childrenCount,
                'notes' => $this->notes,
                'special_requests' => $this->specialRequests,
                'additional_services' => $this->additionalServices,
                'deposit_cost' => $this->weddingHall->deposit_price,
            ];

            $bookingService = new BookingService();
            $result = $bookingService->processBooking(
                auth()->user(),
                $this->weddingHall,
                $bookingData
            );

            if ($result['status'] === 'success') {
                session()->flash('message', $result['message']);

                return redirect()->route('bookings.show', $result['booking']);
            } else {
                session()->flash('error', $result['message']);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.booking-form')->layout('layouts.app');

    }
}
