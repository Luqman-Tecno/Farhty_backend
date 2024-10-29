<div class="py-12" dir="rtl">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl">
            <div class="p-8">
                <!-- Alert Messages -->
                @if (session()->has('message'))
                    <div class="bg-green-100 border-l-4 border-green-500 p-4 rounded-lg flex items-center mb-6">
                        <svg class="h-6 w-6 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <p class="text-green-700">{{ session('message') }}</p>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 p-4 rounded-lg flex items-center mb-6">
                        <svg class="h-6 w-6 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Wedding Hall Images Carousel -->
                @if($booking->weddingHall->images)
                    <div class="mb-8">
                        <div class="relative rounded-2xl overflow-hidden h-96">
                            <div class="flex overflow-x-auto snap-x snap-mandatory">
                                @foreach($booking->weddingHall->images as $image)
                                    <div class="snap-center shrink-0 w-full h-96">
                                        <img src="{{ asset('storage/' . $image) }}" alt="صورة القاعة" class="w-full h-full object-cover rounded-lg shadow-md">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Booking Header -->
                <div class="border-b pb-8 mb-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-4xl font-bold text-gray-800">{{ $booking->weddingHall->hall_name }}</h1>
                            <p class="text-gray-600 mt-2">{{ $booking->weddingHall->city->name_ar }} - {{ $booking->weddingHall->region }}</p>
                        </div>
                        <span class="px-4 py-2 bg-gray-200 rounded-full {{ $this->getStatusColorClass() }}">
                            {{ \App\Enum\BookingStatusEnum::fromValue($booking->status)->getLabel() }}
                        </span>
                    </div>
                </div>

                <!-- Booking Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Main Details -->
                    <div class="space-y-6">
                        <!-- Booking Information -->
                        <div class="bg-gray-100 rounded-xl p-6 shadow-md">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">معلومات الحجز</h3>
                            <div class="space-y-4">
                                @foreach ([
                                    'تاريخ الحجز' => \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d'),
                                    'وقت البداية' =>\Carbon\Carbon::parse($booking->start_time)->format('h:i'),
                                    'وقت النهاية' => \Carbon\Carbon::parse($booking->end_time)->format('h:i'),
                                    'الفترة' => \App\Enum\BookingShiftEnum::fromValue($booking->shift)->getLabel() ,
                                    'عدد الأطفال' => $booking->children_count
                                ] as $label => $value)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">{{ $label }}:</span>
                                        <span class="font-medium">{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Payment Details -->
                        <div class="bg-blue-50 rounded-xl p-6 shadow-md">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">تفاصيل الدفع</h3>
                            <div class="space-y-4">
                                @foreach ([
                                    'التكلفة الإجمالية' => number_format($booking->total_cost, 2) . ' د.ل',
                                    'قيمة العربون' => number_format($booking->deposit_cost, 2) . ' د.ل',
                                    'تكلفة الطفل' => number_format($booking->weddingHall->price_per_child, 2) . ' د.ل',
                                    'حالة العربون' => $booking->deposit_paid ? 'تم الدفع' : 'لم يتم الدفع'
                                ] as $label => $value)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">{{ $label }}:</span>
                                        <span class="font-medium {{ $label === 'حالة العربون' ? ($booking->deposit_paid ? 'text-green-600' : 'text-red-600') : '' }}">{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Wedding Hall Details and Actions -->
                    <div class="space-y-6">
                        <!-- Wedding Hall Details -->
                        <div class="bg-purple-50 rounded-xl p-6 shadow-md">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">تفاصيل القاعة</h3>
                            <div class="space-y-4">
                                @foreach ([
                                    'السعة' => $booking->weddingHall->capacity . ' شخص',
                                    'المنطقة' => $booking->weddingHall->region,
                                    'المدينة' => $booking->weddingHall->city->name_ar
                                ] as $label => $value)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">{{ $label }}:</span>
                                        <span class="font-medium">{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Amenities -->
                        @if($booking->weddingHall->amenities)
                            <div class="bg-green-50 rounded-xl p-6 shadow-md">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">المميزات</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach(explode(',', $booking->weddingHall->amenities) as $amenity)
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>{{ trim($amenity) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Location -->
                        @if($booking->weddingHall->latitude && $booking->weddingHall->longitude)
                            <div class="bg-yellow-50 rounded-xl p-6 shadow-md">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">الموقع</h3>
                                <a href="https://www.google.com/maps?q={{ $booking->weddingHall->latitude }},{{ $booking->weddingHall->longitude }}" target="_blank" class="text-blue-600 hover:text-blue-800 flex items-center">
                                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    عرض على الخريطة
                                </a>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-md">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">الإجراءات المتاحة</h3>
                            <div class="space-y-4">
                                @if($booking->status === 'Pending')
                                    <button wire:click="cancelBooking" wire:confirm="هل أنت متأكد من إلغاء الحجز؟" class="w-full py-3 px-4 bg-red-600 hover:bg-red-700 text-white font-medium rounded-xl transition-colors">
                                        إلغاء الحجز
                                    </button>
                                    @if(!$booking->deposit_paid)
                                        <a href="{{ route('payments.deposit', $booking) }}" class="block w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-colors text-center">
                                            دفع العربون ({{ number_format($booking->deposit_cost, 2) }} ريال)
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
