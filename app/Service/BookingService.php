<?php

namespace App\Service;

use App\Enum\BookingShiftEnum;
use App\Models\Booking;
use App\Models\WeddingHall;
use App\Models\User;
use App\Enum\BookingStatusEnum;
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
                    return ['status' => 'error', 'message' => 'Invalid booking date. Bookings must be made within the allowed time frame.'];
                }

                if (!$this->isShiftAvailable($weddingHall, $bookingData['booking_date'], $bookingData['shift'])) {
                    return ['status' => 'error', 'message' => 'The selected shift is not available for the chosen date.'];
                }

                $basePrice = $weddingHall->getShiftPrice($bookingData['shift']);
                if ($basePrice === null) {
                    return ['status' => 'error', 'message' => 'Invalid shift or price not set for the selected shift.'];
                }

                $childrenCost = $weddingHall->price_per_child * ($bookingData['children_count'] ?? 0);
                $totalCost = $basePrice + $childrenCost;
                $deposit = $this->calculateDeposit($totalCost);

                $booking = new Booking([
                    'user_id' => $user->id,
                    'wedding_hall_id' => $weddingHall->id,
                    'booking_date' => $bookingData['booking_date'],
                    'shift' => $bookingData['shift'],
                    'start_time' => $this->getShiftStartTime($bookingData['shift']),
                    'end_time' => $this->getShiftEndTime($bookingData['shift']),
                    'children_count' => $bookingData['children_count'] ?? 0,
                    'total_cost' => $totalCost,
                    'deposit_cost' => $bookingData['deposit_cost'],
                    'status' => BookingStatusEnum::Pending,
                ]);

                $booking->save();

                return [
                    'status' => 'success',
                    'booking' => $booking,
                    'message' => 'Booking created successfully. Please pay the deposit to confirm.',
                    'cost_breakdown' => [
                        'base_price' => $basePrice,
                        'children_cost' => $childrenCost,
                        'total_cost' => $totalCost,
                        'required_deposit' => $deposit,
                    ],
                ];
            } catch (ValidationException $e) {
                return ['status' => 'error', 'message' => $e->errors()];
            }
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
        if (in_array(BookingShiftEnum::FULL_DAY->value, $bookedShifts) || count($bookedShifts) >= 2) {
            return [];
        }

        $availableShifts = BookingShiftEnum::values();
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
            if ($booking->status !== BookingStatusEnum::Pending) {
                return ['status' => 'error', 'message' => 'Invalid booking status for deposit payment.'];
            }

            try {
                $this->updateBookingStatus($booking, BookingStatusEnum::Booked);
                $booking->deposit_paid = true;
                $booking->deposit_paid_at = now();
                $booking->save();

                return ['status' => 'success', 'message' => 'Deposit paid and booking confirmed.'];
            } catch (\InvalidArgumentException $e) {
                return ['status' => 'error', 'message' => $e->getMessage()];
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


}
