<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\WeddingHall;
use App\Service\BookingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Create a new booking
     */
    public function store(Request $request, WeddingHall $weddingHall): JsonResponse
    {
        $bookingData = $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'shift' => 'required|string',
            'children_count' => 'nullable|integer|min:0',
        ]);

        $result = $this->bookingService->processBooking(
            auth()->user(),
            $weddingHall,
            $bookingData
        );

        return response()->json($result, $result['status'] === 'success' ? 200 : 422);
    }

    /**
     * Get available halls for the next week
     */
    public function getAvailableHalls(): JsonResponse
    {
        $availableHalls = $this->bookingService->getAvailableHallsForNextWeek();
        return response()->json(['status' => 'success', 'data' => $availableHalls]);
    }

    /**
     * Pay deposit for a booking
     */
    public function payDeposit(Booking $booking): JsonResponse
    {
        $result = $this->bookingService->payDeposit($booking);
        return response()->json($result, $result['status'] === 'success' ? 200 : 422);
    }

    /**
     * Cancel a booking
     */
    public function cancel(Booking $booking): JsonResponse
    {
        $this->authorize('update', $booking);

        $result = $this->bookingService->cancelBooking($booking);
        return response()->json($result, $result['status'] === 'success' ? 200 : 422);
    }

    /**
     * Put a booking under review
     */
    public function review(Booking $booking): JsonResponse
    {
        $this->authorize('review', $booking);

        $result = $this->bookingService->reviewBooking($booking);
        return response()->json($result, $result['status'] === 'success' ? 200 : 422);
    }

    /**
     * Approve a booking after review
     */
    public function approve(Booking $booking): JsonResponse
    {
        $this->authorize('approve', $booking);

        $result = $this->bookingService->approveBooking($booking);
        return response()->json($result, $result['status'] === 'success' ? 200 : 422);
    }

    /**
     * Checkout a booking
     */
    public function checkout(Booking $booking): JsonResponse
    {
        $this->authorize('checkout', $booking);

        $result = $this->bookingService->checkoutBooking($booking);
        return response()->json($result, $result['status'] === 'success' ? 200 : 422);
    }

    /**
     * Get user's bookings
     */
    public function getUserBookings(): JsonResponse
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('weddingHall')
            ->orderBy('booking_date', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $bookings
        ]);
    }

    /**
     * Get specific booking details
     */
    public function show(Booking $booking): JsonResponse
    {
        $this->authorize('view', $booking);

        return response()->json([
            'status' => 'success',
            'data' => $booking->load('weddingHall', 'user')
        ]);
    }
}
