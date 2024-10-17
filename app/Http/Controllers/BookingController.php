<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\WeddingHall;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function store(Request $request, WeddingHall $weddingHall)
    {
        $validatedData = $request->validate([
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'total_cost' => 'required|numeric|min:0',
        ]);

        $result = $this->bookingService->processBooking(auth()->user(), $weddingHall, $validatedData);

        if ($result['status'] === 'error') {
            return response()->json($result, 422);
        }

        return response()->json($result, 201);
    }

    public function payDeposit(Request $request, Booking $booking)
    {
        // Here you would typically integrate with a payment gateway

        $result = $this->bookingService->payDeposit($booking);

        return response()->json($result);
    }
    public function availableHallsForNextWeek(): JsonResponse
    {
        $availableHalls = $this->bookingService->getAvailableHallsForNextWeek();

        return response()->json([
            'status' => 'success',
            'data' => [
                'available_halls' => $availableHalls,
            ],
        ]);
    }

    public function cancel(Booking $booking)
    {
        $result = $this->bookingService->cancelBooking($booking);

        return response()->json($result);
    }
}
