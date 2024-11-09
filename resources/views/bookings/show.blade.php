<div>
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

                    <!-- Wedding Hall Images -->
                    @if($booking->weddingHall->images && count($booking->weddingHall->images) > 0)
                        <div class="relative h-[500px] group mb-8" x-data="{ showModal: false, activeSlide: 0, totalSlides: {{ count($booking->weddingHall->images) }} }">
                            <!-- Main Image -->
                            <div class="h-[500px] cursor-pointer" @click="showModal = true">
                                <img src="{{ asset('storage/' . $booking->weddingHall->images[0]) }}" 
                                     alt="{{ $booking->weddingHall->hall_name }}" 
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                
                                <!-- Overlay to indicate clickable -->
                                <div class="absolute inset-0 bg-black/0 hover:bg-black/20 transition-all flex items-center justify-center">
                                    <span class="text-white bg-black/50 px-4 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-all">
                                        عرض جميع الصور
                                    </span>
                                </div>
                            </div>

                            <!-- Images Modal -->
                            <div x-show="showModal" 
                                 x-transition
                                 class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4"
                                 @click.self="showModal = false">
                                
                                <div class="relative w-full max-w-6xl">
                                    <!-- Close Button -->
                                    <button @click="showModal = false" 
                                            class="absolute top-4 right-4 text-white p-2 hover:bg-white/10 rounded-full z-50">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>

                                    <!-- Images Slider -->
                                    <div class="relative h-[80vh]">
                                        @foreach($booking->weddingHall->images as $index => $image)
                                            <div class="absolute inset-0 transition-opacity duration-300"
                                                 x-show="activeSlide === {{ $index }}"
                                                 x-transition:enter="transition ease-out duration-300"
                                                 x-transition:enter-start="opacity-0 transform scale-95"
                                                 x-transition:enter-end="opacity-100 transform scale-100">
                                                <img src="{{ asset('storage/' . $image) }}" 
                                                     alt="{{ $booking->weddingHall->hall_name }}" 
                                                     class="w-full h-full object-contain">
                                            </div>
                                        @endforeach

                                        <!-- Navigation Buttons -->
                                        <button @click="activeSlide = (activeSlide - 1 + totalSlides) % totalSlides" 
                                                class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-all">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                            </svg>
                                        </button>
                                        <button @click="activeSlide = (activeSlide + 1) % totalSlides" 
                                                class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-all">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </button>

                                        <!-- Dots Indicators -->
                                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                            @foreach($booking->weddingHall->images as $index => $image)
                                                <button @click="activeSlide = {{ $index }}" 
                                                        class="w-3 h-3 rounded-full transition-all duration-300"
                                                        :class="activeSlide === {{ $index }} ? 'bg-white scale-110' : 'bg-white/50 hover:bg-white/75'">
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mb-8">
                            <div class="h-[500px] bg-gray-100 flex items-center justify-center rounded-2xl">
                                <span class="text-gray-400 text-lg">لا توجد صورة</span>
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
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">المرافق والخدمات</h3>
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
                                            <a href="{{ route('payment.form', $booking) }}" class="block w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-colors text-center">
                                                دفع العربون ({{ number_format($booking->deposit_cost, 2) }} د.ل)
                                            </a>
                                        @endif
                                    @endif

                                    @if($booking->status === 'Booked')
                                        <a href="{{ route('bookings.invoice', $booking) }}" target="_blank" class="block w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors text-center">
                                            <div class="flex items-center justify-center">
                                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                                </svg>
                                                طباعة الفاتورة
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ showDeleteModal: false }"
         x-on:keydown.escape.window="showDeleteModal = false">
        
        <!-- Modal -->
        <div x-show="showDeleteModal" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="relative bg-white rounded-lg max-w-md w-full p-6"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="text-center">
                        <svg class="mx-auto h-16 w-16 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <h3 class="text-xl font-medium text-gray-900 mt-4">تأكيد إلغاء الحجز</h3>
                        <p class="text-gray-500 mt-2">هل أنت متأكد من رغبتك في إلغاء هذا الحجز؟ لا يمكن التراجع عن هذا الإجراء.</p>
                    </div>
                    <div class="mt-6 flex justify-center gap-4">
                        <button wire:click="cancelBooking" 
                                @click="showDeleteModal = false"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            نعم، إلغاء الحجز
                        </button>
                        <button @click="showDeleteModal = false"
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                            تراجع
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
