<x-filament::card>
    <div class="space-y-6">
        <div class="flex justify-between items-center border-b pb-4">
            <h2 class="text-2xl font-bold text-primary-600">تفاصيل الحجز</h2>
            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ \App\Enum\BookingStatusEnum::from($booking->status)->getLabel() == 'مؤكد' ? 'bg-success-100 text-success-700' : (\App\Enum\BookingStatusEnum::from($booking->status)->getLabel() == 'ملغي' ? 'bg-danger-100 text-danger-700' : 'bg-primary-100 text-primary-700') }}">
                {{ \App\Enum\BookingStatusEnum::from($booking->status)->getLabel() }}
            </span>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">قاعة الزفاف</h3>
                    <p class="mt-1 text-lg font-semibold">{{ $booking->weddingHall->hall_name }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">تاريخ الحجز</h3>
                    <p class="mt-1 text-lg font-semibold">{{ $booking->booking_date->format('Y/m/d') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">الفترة</h3>
                    <p class="mt-1 text-lg font-semibold">{{ \App\Enum\BookingShiftEnum::from($booking->shift)->getLabel() }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">وقت البدء</h3>
                    <p class="mt-1 text-lg font-semibold">{{ $booking->start_time->format('H:i') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">وقت الانتهاء</h3>
                    <p class="mt-1 text-lg font-semibold">{{ $booking->end_time->format('H:i') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">عدد الأطفال</h3>
                    <p class="mt-1 text-lg font-semibold">{{ $booking->children_count }}</p>
                </div>
            </div>
        </div>

        <div class="border-t pt-4">
            <h3 class="text-lg font-semibold mb-4">التفاصيل المالية</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500">تكلفة العربون</h4>
                    <p class="mt-1 text-lg font-semibold">{{ number_format($booking->deposit_cost, 2) }}د.ل </p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">التكلفة الإجمالية</h4>
                    <p class="mt-1 text-lg font-semibold">{{ number_format($booking->total_cost, 2) }}د.ل</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">حالة دفع العربون</h4>
                    <p class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $booking->deposit_paid ? 'bg-success-100 text-success-800' : 'bg-warning-100 text-warning-800' }}">
                            {{ $booking->deposit_paid ? 'تم الدفع' : 'لم يتم الدفع' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-filament::card>
