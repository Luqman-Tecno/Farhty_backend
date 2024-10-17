<?php


namespace App\Services;

use App\Enum\BookingShiftEnum;
use App\Models\Booking;
use App\Models\WeddingHall;
use App\Models\User;
use App\Enum\BookingStatusEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingService
{
    public function processBooking(User $user, WeddingHall $weddingHall, array $bookingData)
    {
        return DB::transaction(function () use ($user, $weddingHall, $bookingData) {
            if (!$this->isShiftAvailable($weddingHall, $bookingData['booking_date'], $bookingData['shift'])) {
                return ['status' => 'error', 'message' => 'The selected shift is not available for the chosen date.'];
            }

            $basePrice = $weddingHall->getShiftPrice($bookingData['shift']);
            if ($basePrice === null) {
                return ['status' => 'error', 'message' => 'Invalid shift or price not set for the selected shift.'];
            }

            $childrenCost = $weddingHall->price_per_child * ($bookingData['children_count'] ?? 0);
            $totalCost = $basePrice + $childrenCost;

            $booking = new Booking([
                'user_id' => $user->id,
                'wedding_hall_id' => $weddingHall->id,
                'booking_date' => $bookingData['booking_date'],
                'shift' => $bookingData['shift'],
                'start_time' => $this->getShiftStartTime($bookingData['shift']),
                'end_time' => $this->getShiftEndTime($bookingData['shift']),
                'children_count' => $bookingData['children_count'] ?? 0,
                'total_cost' => $totalCost,
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
                ],
            ];
        });
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

    private function isShiftAvailable(WeddingHall $weddingHall, $date, $shift)
    {
        $conflictingBookings = Booking::where('wedding_hall_id', $weddingHall->id)
            ->where('booking_date', $date)
            ->whereIn('status', [BookingStatusEnum::Booked, BookingStatusEnum::Pending])
            ->get();

        foreach ($conflictingBookings as $booking) {
            if ($booking->shift ===  BookingShiftEnum::FULL_DAY->value || $shift ===  BookingShiftEnum::FULL_DAY->value || $booking->shift === $shift) {
                return false;
            }
        }

        return true;
    }

    private function getAvailableShiftsForHall(WeddingHall $hall, Carbon $startDate, Carbon $endDate): array
    {
        $bookedShifts = Booking::where('wedding_hall_id', $hall->id)
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->whereIn('status', [BookingStatusEnum::Booked, BookingStatusEnum::Pending])
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
        if (in_array( BookingShiftEnum::FULL_DAY->value, $bookedShifts) || count($bookedShifts) >= 2) {
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
        }
    }

    private function getShiftEndTime(string $shift): string
    {
        switch ($shift) {
            case BookingShiftEnum::DAY->value:
                return '17:00:00';
            case BookingShiftEnum::NIGHT->value:
                return '23:59:59';
            case  BookingShiftEnum::FULL_DAY->value:
                return '23:59:58';
        }
    }


    public function payDeposit(Booking $booking)
    {
        return DB::transaction(function () use ($booking) {
            $booking->deposit_paid = true;
            $booking->status = BookingStatusEnum::Booked;
            $booking->save();

            // Add the booking to the timetable (you might want to create a separate table for this)
            // For now, we'll assume the booking itself serves as the timetable entry

            return ['status' => 'success', 'message' => 'Deposit paid and booking confirmed.'];
        });
    }

    public function cancelBooking(Booking $booking)
    {
        return DB::transaction(function () use ($booking) {
            $booking->status = BookingStatusEnum::Cancelled;
            $booking->save();

            return ['status' => 'success', 'message' => 'Booking cancelled successfully.'];
        });
    }
}
