<div class="container mx-auto p-4 lg:p-8" dir="rtl">
    @if($weddingHall)
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Image Gallery -->
            <div class="relative h-[500px] group">
                @if($weddingHall->images && count($weddingHall->images) > 0)
                    <div class="mb-8" x-data="{ activeSlide: 0, totalSlides: {{ count($weddingHall->images) }} }">
                        <div class="relative h-[500px] overflow-hidden rounded-b-2xl">
                            <div class="flex h-full">
                                @foreach($weddingHall->images as $index => $image)
                                    <div class="absolute w-full h-full transition-opacity duration-300"
                                         x-show="activeSlide === {{ $index }}"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 transform scale-95"
                                         x-transition:enter-end="opacity-100 transform scale-100">
                                        <img src="{{ asset(Storage::url($image)) }}" 
                                             alt="{{ $weddingHall->hall_name }}" 
                                             class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if(count($weddingHall->images) > 1)
                                <!-- أزرار التنقل -->
                                <button @click="activeSlide = (activeSlide - 1 + totalSlides) % totalSlides" 
                                        class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <button @click="activeSlide = (activeSlide + 1) % totalSlides" 
                                        class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>

                                <!-- مؤشرات النقاط -->
                                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                    @foreach($weddingHall->images as $index => $image)
                                        <button @click="activeSlide = {{ $index }}" 
                                                class="w-3 h-3 rounded-full transition-all duration-300"
                                                :class="activeSlide === {{ $index }} ? 'bg-white scale-110' : 'bg-white/50 hover:bg-white/75'">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                        <span class="text-gray-400 text-lg">لا توجد صورة</span>
                    </div>
                @endif

                <!-- Floating Price Badge -->
                @if($currentOffer && $discountedPrice > 0)
                    <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-sm px-6 py-3 rounded-full shadow-lg">
                        <div class="flex flex-col items-center">
                            <span class="text-sm text-gray-500 line-through">{{ number_format($originalPrice, 2) }} د.ل</span>
                            <span class="text-2xl font-bold text-purple-900">
                                {{ number_format($discountedPrice, 2) }}
                                <span class="text-sm font-medium">د.ل</span>
                            </span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Content Section -->
            <div class="p-8 lg:p-10">
                <!-- Header -->
                <div class="space-y-4">
                    <div class="flex justify-between items-start">
                        <h1 class="text-4xl font-bold text-gray-900">{{ $weddingHall->hall_name }}</h1>
                        @if($currentOffer && $discountPercentage > 0)
                            <div class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-lg font-bold">
                                خصم {{ number_format($discountPercentage, 0) }}%
                            </div>
                        @endif
                    </div>
                    <div class="flex items-center text-gray-600 gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-lg">{{ optional($weddingHall->city)->name_ar }} {{ $weddingHall->region ? "- {$weddingHall->region}" : '' }}</span>
                    </div>
                </div>

                <!-- Key Features -->
                <div class="mt-8 grid grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-purple-50/50 p-6 rounded-2xl border border-purple-100 hover:border-purple-200 transition-colors">
                        <div class="text-purple-900 mb-1 text-sm font-medium">السعة</div>
                        <div class="text-2xl font-bold text-purple-900">{{ $weddingHall->capacity }}
                            <span class="text-base font-medium text-purple-600">كرسي</span>
                        </div>
                    </div>
                    <div class="bg-purple-50/50 p-6 rounded-2xl border border-purple-100 hover:border-purple-200 transition-colors">
                        <div class="text-purple-900 mb-1 text-sm font-medium">العربون</div>
                        <div class="text-2xl font-bold text-purple-900">{{ $weddingHall->deposit_price }}
                            <span class="text-base font-medium text-purple-600">د.ل</span>
                        </div>
                    </div>
                    <div class="bg-purple-50/50 p-6 rounded-2xl border border-purple-100 hover:border-purple-200 transition-colors">
                        <div class="text-purple-900 mb-1 text-sm font-medium">سعر الطفل</div>
                        <div class="text-2xl font-bold text-purple-900">{{ $weddingHall->price_per_child }}
                            <span class="text-base font-medium text-purple-600">د.ل</span>
                        </div>
                    </div>
                    @if($currentOffer && $savingAmount > 0)
                        <div class="bg-green-50/50 p-6 rounded-2xl border border-green-100 hover:border-green-200 transition-colors">
                            <div class="text-green-900 mb-1 text-sm font-medium">قيمة التوفير</div>
                            <div class="text-2xl font-bold text-green-900">{{ number_format($savingAmount, 2) }}
                                <span class="text-base font-medium text-green-600">د.ل</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- وصف القاعة -->
                @if($weddingHall->description)
                    <div class="mt-10">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">وصف القاعة</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $weddingHall->description }}</p>
                    </div>
                @endif

                <!-- المميزات -->
                @if($weddingHall->amenities && is_array($weddingHall->amenities) && count($weddingHall->amenities) > 0)
                    <div class="mt-10">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">المميزات</h3>
                        <div class="grid grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($weddingHall->amenities as $amenity)
                                <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-xl">
                                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700">{{ $amenity }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Booking Section -->
                <div class="mt-10 bg-gradient-to-br from-purple-50 to-purple-100/50 p-8 rounded-2xl border border-purple-100">
                    <h3 class="text-2xl font-bold text-purple-900 mb-6">مواعيد الحجز المتاحة</h3>
                    
                    @include('livewire.components.calendar')

                    <!-- Selected Date Section -->
                    @if($selectedDate)
                        <div class="mt-6 p-4 bg-white rounded-lg shadow-sm">
                            <p class="text-lg mb-4">
                                التاريخ المختار: <strong>{{ \Carbon\Carbon::parse($selectedDate)->locale('ar')->format('j F Y') }}</strong>
                            </p>
                            <button
                                wire:click="proceedToBooking"
                                class="w-full bg-purple-900 text-white py-4 px-6 rounded-xl hover:bg-purple-800 transition-colors duration-200 text-lg font-medium"
                            >
                                احجز الآن
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <!-- رسالة الخطأ -->
        <div class="text-center py-12">
            <div class="bg-red-50 p-6 rounded-xl max-w-lg mx-auto">
                <svg class="w-16 h-16 text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-xl font-bold text-red-600 mb-2">عذراً</h3>
                <p class="text-gray-600">لم يتم العثور على القاعة المطلوبة أو أنها غير متاحة حالياً</p>
                <a href="{{ route('offers') }}" class="mt-4 inline-block text-purple-600 hover:text-purple-700">
                    العودة إلى قائمة القاعات
                </a>
            </div>
        </div>
    @endif

    <!-- Modal تسجيل الدخول -->
    @if($showLoginModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white p-8 rounded-2xl max-w-md w-full shadow-2xl">
                <h3 class="text-2xl font-bold text-center mb-4">يجب تسجيل الدخول للحجز</h3>
                <p class="text-gray-600 text-center mb-8">
                    من فضلك قم بتسجيل الدخول أو إنشاء حساب جديد للمتابعة
                </p>
                <div class="flex gap-4">
                    <a href="{{ route('login') }}"
                       class="flex-1 bg-purple-900 text-white py-3 px-6 rounded-xl text-center hover:bg-purple-800 transition-colors duration-200">
                        تسجيل الدخول
                    </a>
                    <a href="{{ route('register') }}"
                       class="flex-1 bg-gray-100 text-gray-900 py-3 px-6 rounded-xl text-center hover:bg-gray-200 transition-colors duration-200">
                        حساب جديد
                    </a>
                </div>
                <button
                    wire:click="$set('showLoginModal', false)"
                    class="mt-6 w-full text-gray-500 hover:text-gray-700 transition-colors duration-200"
                >
                    إغلاق
                </button>
            </div>
        </div>
    @endif
</div>
