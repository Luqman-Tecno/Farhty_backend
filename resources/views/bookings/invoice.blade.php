<div class="py-12" dir="rtl">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
            <!-- Invoice Header -->
            <div class="border-b pb-8 mb-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">فاتورة حجز</h1>
                        <p class="text-gray-600 mt-2">رقم الفاتورة: #{{ $booking->id }}</p>
                        <p class="text-gray-600">تاريخ الإصدار: {{ now()->format('Y-m-d') }}</p>
                    </div>
                    <button wire:click="downloadPdf" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        تحميل PDF
                    </button>
                </div>
            </div>

            <!-- Customer & Venue Details -->
            <div class="grid grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">معلومات العميل</h3>
                    <div class="space-y-2">
                        <p><span class="font-medium">الاسم:</span> {{ $booking->user->name }}</p>
                        <p><span class="font-medium">البريد الإلكتروني:</span> {{ $booking->user->email }}</p>
                        <p><span class="font-medium">رقم الهاتف:</span> {{ $booking->user->phone }}</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">معلومات القاعة</h3>
                    <div class="space-y-2">
                        <p><span class="font-medium">اسم القاعة:</span> {{ $booking->weddingHall->hall_name }}</p>
                        <p><span class="font-medium">المدينة:</span> {{ $booking->weddingHall->city->name_ar }}</p>
                        <p><span class="font-medium">المنطقة:</span> {{ $booking->weddingHall->region }}</p>
                    </div>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4">تفاصيل الحجز</h3>
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <p><span class="font-medium">تاريخ الحجز:</span> {{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}</p>
                        <p><span class="font-medium">الفترة:</span> {{ \App\Enum\BookingShiftEnum::fromValue($booking->shift)->getLabel() }}</p>
                        <p><span class="font-medium">وقت البداية:</span> {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}</p>
                        <p><span class="font-medium">وقت النهاية:</span> {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</p>
                        <p><span class="font-medium">عدد الأطفال:</span> {{ $booking->children_count }}</p>
                        <p><span class="font-medium">حالة الحجز:</span> {{ \App\Enum\BookingStatusEnum::fromValue($booking->status)->getLabel() }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="border-t pt-8">
                <h3 class="text-lg font-semibold mb-4">تفاصيل الدفع</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span>التكلفة الأساسية</span>
                        <span>{{ number_format($booking->total_cost - ($booking->children_count * $booking->weddingHall->price_per_child), 2) }} د.ل</span>
                    </div>
                    @if($booking->children_count > 0)
                        <div class="flex justify-between items-center">
                            <span>تكلفة الأطفال ({{ $booking->children_count }} × {{ number_format($booking->weddingHall->price_per_child, 2) }})</span>
                            <span>{{ number_format($booking->children_count * $booking->weddingHall->price_per_child, 2) }} د.ل</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-center font-bold text-lg border-t pt-4">
                        <span>الإجمالي</span>
                        <span>{{ number_format($booking->total_cost, 2) }} د.ل</span>
                    </div>
                    <div class="flex justify-between items-center text-blue-600">
                        <span>العربون المدفوع</span>
                        <span>{{ number_format($booking->deposit_cost, 2) }} د.ل</span>
                    </div>
                    <div class="flex justify-between items-center font-bold text-lg border-t pt-4">
                        <span>المتبقي</span>
                        <span>{{ number_format($booking->total_cost - $booking->deposit_cost, 2) }} د.ل</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 