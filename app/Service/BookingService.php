<?php

namespace App\Service;

use App\Enum\BookingShiftEnum;
use App\Models\Booking;
use App\Models\WeddingHall;
use App\Models\User;
use App\Enum\BookingStatusEnum;
use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
 class BookingService
{
    public function processBooking(User $user, WeddingHall $weddingHall, array $bookingData)
    {
        return DB::transaction(function () use ($user, $weddingHall, $bookingData) {
            try {
                $this->validateBookingData($bookingData);

                $bookingDate = Carbon::parse($bookingData['booking_date']);
                if (!$this->isValidBookingDate($bookingDate)) {
                    return ['status' => 'error', 'message' => 'التاريخ غير صالح للحجز'];
                }

                if (!$this->isShiftAvailable($weddingHall, $bookingData['booking_date'], $bookingData['shift'])) {
                    return ['status' => 'error', 'message' => 'الفترة غير متاحة للحجز'];
                }

                $basePrice = $this->calculateBasePrice($weddingHall, $bookingData['shift']);
                
                $childrenCount = (int) ($bookingData['children_count'] ?? 0);
                $childrenCost = $weddingHall->price_per_child * $childrenCount;

                $additionalServices = $bookingData['additional_services'] ?? [];
                $servicesCost = $this->calculateServicesCost($additionalServices);
                
                $totalCost = $basePrice + $childrenCost + $servicesCost;
                
                $depositAmount = $weddingHall->deposit_price ?? ($basePrice * 0.3);

                $booking = new Booking([
                    'user_id' => $user->id,
                    'wedding_hall_id' => $weddingHall->id,
                    'booking_date' => $bookingData['booking_date'],
                    'shift' => $bookingData['shift'],
                    'start_time' => $this->getShiftStartTime($bookingData['shift']),
                    'end_time' => $this->getShiftEndTime($bookingData['shift']),
                    'children_count' => $childrenCount,
                    'total_cost' => $totalCost,
                    'deposit_cost' => $depositAmount,
                    'status' => BookingStatusEnum::Pending,
                ]);

                $booking->save();

                if (!empty($additionalServices)) {
                    foreach ($additionalServices as $serviceId => $quantity) {
                        if ($quantity > 0) {
                            $booking->services()->attach($serviceId, ['quantity' => $quantity]);
                        }
                    }
                }

                return [
                    'status' => 'success',
                    'booking' => $booking,
                    'message' => 'تم إنشاء الحجز بنجاح. يرجى دفع العربون للتأكيد.',
                    'cost_breakdown' => [
                        'base_price' => $basePrice,
                        'children_cost' => $childrenCost,
                        'services_cost' => $servicesCost,
                        'total_cost' => $totalCost,
                        'deposit_required' => $depositAmount,
                    ],
                ];
            } catch (ValidationException $e) {
                return ['status' => 'error', 'message' => $e->errors()];
            } catch (\Exception $e) {
                return ['status' => 'error', 'message' => 'حدث خطأ أثناء إنشاء الحجز: ' . $e->getMessage()];
            }
        });
    }
    
    public function calculateServicesCost(array $services): float
    {
        if (empty($services)) {
            return 0;
        }

        return collect($services)->sum(function($quantity, $serviceId) {
            $service = Services::find($serviceId);
            return $service ? ($service->price * (int)$quantity) : 0;
        });
    }

    private function validateBookingData(array $bookingData)
    {
        $rules = [
            'booking_date' => 'required|date|after_or_equal:today',
            'shift' => 'required|in:' . implode(',', BookingShiftEnum::values()),
            'children_count' => 'nullable|integer|min:0'
        ];

        $validator = Validator::make($bookingData, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    private function isValidBookingDate(Carbon $bookingDate): bool
    {
        $maxAdvanceBookingDays = 180; // 6 months
        return $bookingDate->isFuture() &&
            $bookingDate->diffInDays(now()) <= $maxAdvanceBookingDays;
    }

    private function calculateDeposit(float $totalCost): float
    {
        return $totalCost * 0.3; // 30% deposit
    }

    public function getAvailableHallsForNextWeek(): Collection
    {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->addWeek()->endOfDay();

        $availableHalls = WeddingHall::all();

        return $availableHalls->map(function ($hall) use ($startDate, $endDate) {
            $availableShifts = $this->getAvailableShiftsForHall($hall, $startDate, $endDate);
            return [
                'id' => $hall->id,
                'name' => $hall->name,
                'available_shifts' => $availableShifts,
            ];
        });
    }

    public function isShiftAvailable(WeddingHall $weddingHall, $date, $shift)
    {
        $existingBookings = Booking::where('wedding_hall_id', $weddingHall->id)
            ->where('booking_date', $date)
            ->whereIn('status', [
                BookingStatusEnum::Booked->value,
                BookingStatusEnum::Pending->value,
                BookingStatusEnum::ON_REVIEW->value
            ])
            ->get();

        $shiftStart = Carbon::parse($date . ' ' . $this->getShiftStartTime($shift));
        $shiftEnd = Carbon::parse($date . ' ' . $this->getShiftEndTime($shift));

        return !$this->hasTimeConflict($shiftStart, $shiftEnd, $existingBookings);
    }

    private function hasTimeConflict(Carbon $startTime, Carbon $endTime, Collection $existingBookings): bool
    {
        return $existingBookings->contains(function ($booking) use ($startTime, $endTime) {
            $bookingStart = Carbon::parse($booking->start_time);
            $bookingEnd = Carbon::parse($booking->end_time);

            return $startTime->between($bookingStart, $bookingEnd) ||
                $endTime->between($bookingStart, $bookingEnd) ||
                ($startTime->lte($bookingStart) && $endTime->gte($bookingEnd));
        });
    }

    public function getAvailableShiftsForHall(WeddingHall $hall, Carbon $startDate, Carbon $endDate): array
    {
        $bookedShifts = Booking::where('wedding_hall_id', $hall->id)
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->whereIn('status', [
                BookingStatusEnum::Booked->value,
                BookingStatusEnum::Pending->value,
                BookingStatusEnum::ON_REVIEW->value
            ])
            ->get()
            ->groupBy('booking_date')
            ->map(function ($bookings) {
                return $bookings->pluck('shift')->toArray();
            })
            ->toArray();

        $availableShifts = [];
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $dayShifts = $bookedShifts[$formattedDate] ?? [];

            $availableShifts[$formattedDate] = $this->getAvailableShiftsForDate($dayShifts);
        }

        return $availableShifts;
    }
    private function getAvailableShiftsForDate(array $bookedShifts): array
    {
        // إذا كان هناك أي حجز (يوم كامل أو أي فترة أخرى)، لا يمكن حجز يوم كامل
        if (!empty($bookedShifts)) {
            $availableShifts = [
                BookingShiftEnum::DAY->value,
                BookingShiftEnum::NIGHT->value
            ];
        } else {
            // إذا لم يكن هناك حجوزات، يمكن حجز أي فترة بما في ذلك اليوم الكامل
            $availableShifts = BookingShiftEnum::values();
        }

        // إزالة الفترات المحجوزة من الفترات المتاحة
        return array_values(array_diff($availableShifts, $bookedShifts));
    }

    private function getShiftStartTime(string $shift): string
    {
        switch ($shift) {
            case BookingShiftEnum::DAY->value:
                return '08:00:00';
            case BookingShiftEnum::NIGHT->value:
                return '18:00:00';
            case BookingShiftEnum::FULL_DAY->value:
                return '08:00:01';
            default:
                throw new \InvalidArgumentException('Invalid shift');
        }
    }

    private function getShiftEndTime(string $shift): string
    {
        switch ($shift) {
            case BookingShiftEnum::DAY->value:
                return '17:00:00';
            case BookingShiftEnum::NIGHT->value:
                return '23:59:59';
            case BookingShiftEnum::FULL_DAY->value:
                return '23:59:58';
            default:
                throw new \InvalidArgumentException('Invalid shift');
        }
    }

    public function payDeposit(Booking $booking)
    {
        return DB::transaction(function () use ($booking) {
            try {
                if ($booking->status !== BookingStatusEnum::Pending->value) {
                    throw new \Exception('لا يمكن دفع التأمين - حالة الحجز غير صحيحة');
                }

                if ($booking->deposit_paid) {
                    throw new \Exception('تم دفع التأمين مسبقاً');
                }

                $this->updateBookingStatus($booking, BookingStatusEnum::Booked);
                
                $booking->deposit_paid = true;
             
                $booking->save();

                return [
                    'status' => 'success',
                    'message' => 'تم تأكيد الحجز ودفع التأمين بنجاح',
                    'booking' => $booking
                ];

            } catch (\Exception $e) {
                return [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        });
    }

    public function cancelBooking(Booking $booking)
    {
        return DB::transaction(function () use ($booking) {
            try {
                $this->updateBookingStatus($booking, BookingStatusEnum::Cancelled);
                $refundAmount = $this->calculateRefund($booking);
                $booking->refund_amount = $refundAmount;
                $booking->cancelled_at = now();
                $booking->save();

                return [
                    'status' => 'success',
                    'message' => 'Booking cancelled successfully.',
                    'refund_amount' => $refundAmount
                ];
            } catch (\InvalidArgumentException $e) {
                return ['status' => 'error', 'message' => $e->getMessage()];
            }
        });
    }

    private function calculateRefund(Booking $booking): float
    {
        if (!$booking->deposit_paid) {
            return 0;
        }

        $daysUntilBooking = Carbon::now()->diffInDays($booking->booking_date, false);

        if ($daysUntilBooking > 30) {
            return $booking->total_cost * 0.7; // 70% refund
        } elseif ($daysUntilBooking > 14) {
            return $booking->total_cost * 0.5; // 50% refund
        }

        return 0; // No refund for cancellations within 14 days
    }

    private function updateBookingStatus(Booking $booking, BookingStatusEnum $newStatus): void
    {
        $allowedTransitions = [
            BookingStatusEnum::Pending->value => [
                BookingStatusEnum::Booked->value,
                BookingStatusEnum::Cancelled->value,
                BookingStatusEnum::ON_REVIEW->value
            ],
            BookingStatusEnum::Booked->value => [
                BookingStatusEnum::Cancelled->value,
                BookingStatusEnum::CHECKOUT->value,
                BookingStatusEnum::ON_REVIEW->value
            ],
            BookingStatusEnum::ON_REVIEW->value => [
                BookingStatusEnum::Booked->value,
                BookingStatusEnum::Cancelled->value
            ],
            BookingStatusEnum::CHECKOUT->value => [], // Final state
            BookingStatusEnum::Cancelled->value => [] // Final state
        ];

        if (!isset($allowedTransitions[$booking->status]) ||
            (!empty($allowedTransitions[$booking->status]) &&
                !in_array($newStatus->value, $allowedTransitions[$booking->status]))) {
            throw new \InvalidArgumentException('Invalid status transition from ' . $booking->status . ' to ' . $newStatus->value);
        }

        $booking->status = $newStatus;
    }

    public function reviewBooking(Booking $booking)
    {
        return DB::transaction(function () use ($booking) {
            try {
                $this->updateBookingStatus($booking, BookingStatusEnum::ON_REVIEW);
                $booking->review_started_at = now();
                $booking->save();

                return [
                    'status' => 'success',
                    'message' => 'Booking is now under review.',
                    'booking' => $booking
                ];
            } catch (\InvalidArgumentException $e) {
                return ['status' => 'error', 'message' => $e->getMessage()];
            }
        });
    }

    public function checkoutBooking(Booking $booking)
    {
        return DB::transaction(function () use ($booking) {
            try {
                $this->updateBookingStatus($booking, BookingStatusEnum::CHECKOUT);
                $booking->checkout_at = now();
                $booking->save();

                return [
                    'status' => 'success',
                    'message' => 'Booking has been checked out successfully.',
                    'booking' => $booking
                ];
            } catch (\InvalidArgumentException $e) {
                return ['status' => 'error', 'message' => $e->getMessage()];
            }
        });
    }

    public function approveBooking(Booking $booking)
    {
        return DB::transaction(function () use ($booking) {
            try {
                if ($booking->status !== BookingStatusEnum::ON_REVIEW) {
                    throw new \InvalidArgumentException('Booking must be under review to be approved.');
                }

                $this->updateBookingStatus($booking, BookingStatusEnum::Booked);
                $booking->approved_at = now();
                $booking->save();

                return [
                    'status' => 'success',
                    'message' => 'Booking has been approved successfully.',
                    'booking' => $booking
                ];
            } catch (\InvalidArgumentException $e) {
                return ['status' => 'error', 'message' => $e->getMessage()];
            }
        });
    }

    public function getAvailableDates(WeddingHall $weddingHall)
    {
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addMonths(6); // نعرض 6 أشهر مقدماً
        $dates = [];

        $bookedDates = Booking::where('wedding_hall_id', $weddingHall->id)
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->whereIn('status', [
                BookingStatusEnum::Booked->value,
                BookingStatusEnum::Pending->value,
                BookingStatusEnum::ON_REVIEW->value
            ])
            ->get()
            ->groupBy(function($booking) {
                return Carbon::parse($booking->booking_date)->format('Y-m-d');
            });

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $bookedShifts = $bookedDates->get($dateStr, collect())->pluck('shift')->toArray();
            
            $isFullyBooked = in_array(BookingShiftEnum::FULL_DAY->value, $bookedShifts) || 
                count($bookedShifts) >= 2;

            $dates[] = [
                'date' => $dateStr,
                'available' => !$isFullyBooked,
                'day_name' => $date->locale('ar')->dayName,
                'shifts' => $this->getAvailableShiftsForDate($bookedShifts),
                'is_weekend' => $date->isWeekend(),
                'formatted_date' => $date->locale('ar')->format('j F Y'),
            ];
        }

        return $dates;
    }

    public function calculateBasePrice(WeddingHall $weddingHall, string $shift): float
    {
        $activeSale = $weddingHall->offerSales()
            ->where('status', 1)
            ->first();

        if ($activeSale) {
            return $activeSale->sale_price;
        }

        $shiftPrices = $weddingHall->shift_prices;
        return $shiftPrices[$shift] ?? 0;
    }

}
