<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\WeddingHall;
use App\Service\BookingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingForm extends Component
{
    public $weddingHall;
    public $selectedDate;
    public $shift = '';
    public $childrenCount = 0;
    public $notes;
    public $specialRequests;
    public $additionalServices = [];
    public $priceBreakdown = [];
    public $errorMessage = '';
    public $loading = false;

    protected $rules = [
        'selectedDate' => 'required|date|after_or_equal:today',
        'shift' => 'required|in:day,night,full_day',
        'childrenCount' => 'nullable|integer|min:0',
        'notes' => 'nullable|string|max:500',
        'specialRequests' => 'nullable|string|max:500',
        'additionalServices.*' => 'nullable|integer|min:0'
    ];

    public function mount(WeddingHall $weddingHall, $date = null)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->weddingHall = $weddingHall->load(['services', 'offerSales']);
        
        try {
            $this->selectedDate = $date ? Carbon::parse($date)->format('Y-m-d') : now()->format('Y-m-d');
        } catch (\Exception $e) {
            $this->selectedDate = now()->format('Y-m-d');
        }

        $this->initializeServices();
        $this->calculatePrice();
    }

    protected function initializeServices()
    {
        if ($this->weddingHall->services) {
            foreach ($this->weddingHall->services as $service) {
                $this->additionalServices[$service->id] = 0;
            }
        }
    }

    public function updatedShift()
    {
        $this->calculatePrice();
    }

    public function updatedChildrenCount()
    {
        $this->validateOnly('childrenCount');
        $this->calculatePrice();
    }

    public function updatedAdditionalServices()
    {
        $this->calculatePrice();
    }

    public function submit()
    {
        if (!auth()->check()) {
            session()->flash('error', 'يجب تسجيل الدخول أولاً');
            return redirect()->route('login');
        }

        $this->loading = true;
        $this->errorMessage = '';

        try {
            $validatedData = $this->validate();

            if (!$this->isDateAndShiftAvailable()) {
                $this->errorMessage = 'عذراً، هذا التاريخ أو الفترة غير متاحة للحجز';
                $this->loading = false;
                return;
            }

            DB::beginTransaction();

            $bookingService = new BookingService();
            $bookingData = [
                'wedding_hall_id' => $this->weddingHall->id,
                'user_id' => auth()->id(),
                'booking_date' => $this->selectedDate,
                'shift' => $this->shift,
                'children_count' => $this->childrenCount,
                'notes' => $this->notes,
                'special_requests' => $this->specialRequests,
                'additional_services' => array_filter($this->additionalServices),
                'total_cost' => $this->priceBreakdown['total'] ?? 0,
                'deposit_amount' => $this->priceBreakdown['deposit_required'] ?? 0,
                'status' => 'pending'
            ];

            $result = $bookingService->processBooking(
                auth()->user(),
                $this->weddingHall,
                $bookingData
            );

            if ($result['status'] === 'success') {
                DB::commit();
                session()->flash('message', 'تم إنشاء الحجز بنجاح!');
                return redirect()->route('bookings.show', ['booking' => $result['booking']->id]);
            } else {
                DB::rollBack();
                $this->errorMessage = is_array($result['message']) 
                    ? implode(' ', $result['message']) 
                    : $result['message'];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking Error: ' . $e->getMessage());
            $this->errorMessage = 'حدث خطأ أثناء إنشاء الحجز. الرجاء المحاولة مرة أخرى.';
        } finally {
            $this->loading = false;
        }
    }

    protected function calculatePrice()
    {
        if (!$this->shift || !$this->weddingHall) {
            return;
        }

        try {
            $bookingService = new BookingService();
            
            // حساب السعر الأساسي
            $basePrice = $bookingService->calculateBasePrice($this->weddingHall, $this->shift);
            
            // حساب تكلفة الأطفال
            $childrenCost = $this->weddingHall->price_per_child 
                ? ($this->weddingHall->price_per_child * max(0, (int)$this->childrenCount))
                : 0;
            
            // حساب تكلفة الخدمات الإضافية
            $servicesCost = $this->calculateServicesCost();

            $total = $basePrice + $childrenCost + $servicesCost;
            

            $this->priceBreakdown = [
                'base_price' => $basePrice,
                'children_cost' => $childrenCost,
                'services_cost' => $servicesCost,
                'total' => $total,
                'deposit_required' => $this->weddingHall->deposit_price,
                'has_offer' => $this->weddingHall->getCurrentOffer() !== null
            ];
        } catch (\Exception $e) {
            Log::error('Price Calculation Error: ' . $e->getMessage());
            $this->errorMessage = 'حدث خطأ في حساب السعر';
        }
    }

    protected function calculateServicesCost()
    {
        if (!$this->weddingHall->services) {
            return 0;
        }

        return collect($this->additionalServices)
            ->map(function($quantity, $serviceId) {
                $service = $this->weddingHall->services->firstWhere('id', $serviceId);
                return $service ? ($service->price * max(0, (int)$quantity)) : 0;
            })
            ->sum();
    }

    protected function isDateAndShiftAvailable()
    {
        try {
            $bookingService = new BookingService();
            $availableDates = $bookingService->getAvailableDates($this->weddingHall);
            
            $dateInfo = collect($availableDates)
                ->firstWhere('date', $this->selectedDate);
            
            return $dateInfo && 
                   $dateInfo['available'] && 
                   in_array($this->shift, $dateInfo['shifts'] ?? []);
        } catch (\Exception $e) {
            Log::error('Availability Check Error: ' . $e->getMessage());
            return false;
        }
    }

    public function getAvailableShiftsProperty()
    {
        $bookingService = new BookingService();
        $availableDates = $bookingService->getAvailableDates($this->weddingHall);
        $dateInfo = collect($availableDates)->firstWhere('date', $this->selectedDate);
        
        return $dateInfo['shifts'] ?? [];
    }

    public function render()
    {
        return view('livewire.booking-form')->layout('layouts.app');
    }
}
