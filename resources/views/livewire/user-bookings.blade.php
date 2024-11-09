<div class="mx-auto max-w-4xl space-y-6 p-4" dir="rtl">
    @forelse ($bookings as $booking)
        <div class="relative overflow-hidden rounded-2xl bg-white shadow-sm transition-all duration-300 hover:shadow-xl">
            <!-- Status Bar -->
            <div class="relative h-2 w-full">
                <div class="absolute inset-0
                    @switch($booking->status)
                        @case('Booked')
                            bg-gradient-to-r from-emerald-500 to-emerald-600
                            @break
                        @case('Cancelled')
                            bg-gradient-to-r from-red-500 to-red-600
                            @break
                        @case('Pending')
                            bg-gradient-to-r from-yellow-500 to-yellow-600
                            @break
                        @case('Checkout')
                            bg-gradient-to-r from-blue-500 to-blue-600
                            @break
                        @case('On Review')
                            bg-gradient-to-r from-purple-500 to-purple-600
                            @break
                    @endswitch
                "></div>
            </div>

            <div class="p-6">
                <!-- Header with Status -->
                <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="rounded-xl bg-indigo-50/50 p-3">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $booking->weddingHall->hall_name }}</h3>
                            <p class="mt-1 text-sm text-gray-500">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="flex items-center border gap-2 rounded-full px-4 py-2 text-sm font-medium
                            @switch($booking->status)
                                @case('Booked')
                                    bg-emerald-50 text-emerald-700
                                    @break
                                @case('Cancelled')
                                    bg-red-50 text-red-700
                                    @break
                                @case('Pending')
                                    bg-yellow-50 text-yellow-700
                                    @break
                                @case('Checkout')
                                    bg-blue-50 text-blue-700
                                    @break
                                @case('On Review')
                                    bg-purple-50 text-purple-700
                                    @break
                            @endswitch
                        ">
                            <span class="h-2.5 w-2.5 rounded-full animate-pulse
                                @switch($booking->status)
                                    @case('Booked')
                                        bg-emerald-500
                                        @break
                                    @case('Cancelled')
                                        bg-red-500
                                        @break
                                    @case('Pending')
                                        bg-yellow-500
                                        @break
                                    @case('Checkout')
                                        bg-blue-500
                                        @break
                                    @case('On Review')
                                        bg-purple-500
                                        @break
                                @endswitch
                            "></span>
                            {{ \App\Enum\BookingStatusEnum::fromValue($booking->status)->getLabel() }}
                        </div>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="grid gap-6 lg:grid-cols-2">
                    <!-- Booking Details -->
                    <div class="rounded-xl bg-gray-50/50 p-4">
                        <h4 class="mb-4 text-sm font-medium text-gray-400">تفاصيل الحجز</h4>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">تاريخ الحجز</span>
                                <span class="font-semibold text-gray-900">{{ $booking->booking_date->format('Y/m/d') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">الفترة</span>
                                <span class="font-semibold text-gray-900">{{ \App\Enum\BookingShiftEnum::fromValue($booking->shift)->getLabel()  }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">الوقت</span>
                                <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">عدد الأطفال</span>
                                <div class="flex items-center gap-2">
                                    <span class="rounded-lg bg-indigo-100 px-2.5 py-1 text-sm font-semibold text-indigo-600">
                                        {{ $booking->children_count }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div class="rounded-xl bg-gray-50/50 p-4">
                        <h4 class="mb-4 text-sm font-medium text-gray-400">تفاصيل الدفع</h4>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">العربون</span>
                                <span class="font-semibold text-emerald-600">{{ number_format($booking->deposit_cost, 2) }} د.ل</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">المبلغ الإجمالي</span>
                                <span class="font-semibold text-emerald-600">{{ number_format($booking->total_cost, 2) }} د.ل</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">حالة العربون</span>
                                <span class="rounded-full px-3 py-1 text-sm font-medium
                                    {{ $booking->deposit_paid ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                    {{ $booking->deposit_paid ? 'تم الدفع' : 'لم يتم الدفع' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="mt-6 flex justify-end gap-4 border-t border-gray-100 pt-6">


                    <a href="{{ route('bookings.show', $booking->id) }}"
                       class="group inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-medium text-white transition-all duration-200 hover:bg-indigo-700">
                        عرض التفاصيل
                        <svg class="h-5 w-5 transform transition-transform duration-200 group-hover:translate-x-[-4px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="flex min-h-[300px] items-center justify-center rounded-2xl bg-white p-6">
            <div class="text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-50">
                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">لا توجد حجوزات</h3>
                <p class="mt-2 text-sm text-gray-500">لم يتم العثور على أي حجوزات في النظام.</p>
            </div>
        </div>
    @endforelse
</div>
