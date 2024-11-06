<div class="min-h-screen bg-gray-50" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- القسم الرئيسي -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">العروض المميزة للقاعات</h1>
            <p class="mt-2 text-gray-600">اكتشف أفضل العروض والخصومات على قاعات الأفراح</p>
        </div>

        <!-- شبكة القاعات -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($halls as $hall)
                @php
                    $currentOffer = $hall->getCurrentOffer();
                    $originalPrice = $hall->getOriginalPrice() ?? 0;
                    $discountedPrice = $currentOffer?->sale_price ?? $originalPrice;
                    $discountPercentage = $currentOffer?->calculateDiscountPercentage() ?? 0;
                    $savingAmount = $currentOffer?->getSavingAmount() ?? 0;
                    $offerEndDate = $currentOffer?->end_date;
                    $images = is_array($hall->images) ? $hall->images : [];
                @endphp

                <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <!-- قسم الصورة -->
                    <div class="relative aspect-[16/9] overflow-hidden bg-gray-100">
                        @if(count($images) > 0)
                            <img src="{{ asset(Storage::url($images[0])) }}"
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                 alt="{{ $hall->hall_name }}"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-gray-400">لا توجد صورة</span>
                            </div>
                        @endif

                        <!-- الشارات -->
                        @if($hall->capacity)
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-medium text-gray-700">
                                {{ $hall->capacity }} شخص
                            </div>
                        @endif

                        @if($currentOffer && $discountPercentage > 0)
                            <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                خصم {{ number_format($discountPercentage, 0) }}%
                            </div>
                        @endif
                    </div>

                    <div class="p-6 space-y-4">
                        <!-- معلومات القاعة -->
                        <div class="flex justify-between items-start">
                            <h3 class="text-xl font-bold text-gray-900">{{ $hall->hall_name }}</h3>
                            @if($currentOffer && $originalPrice > 0)
                                <div class="flex flex-col items-end">
                                    <span class="text-lg line-through text-gray-400">{{ number_format($originalPrice, 2) }} د.ل</span>
                                    <span class="text-xl font-bold text-green-600">{{ number_format($discountedPrice, 2) }} د.ل</span>
                                </div>
                            @endif
                        </div>

                        <!-- الموقع والتفاصيل -->
                        <div class="space-y-2">
                            @if($hall->city || $hall->region)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ optional($hall->city)->name_ar }} {{ $hall->region ? "- {$hall->region}" : '' }}
                                </div>
                            @endif

                            @if($offerEndDate)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    ينتهي العرض: {{ $offerEndDate->format('Y-m-d') }}
                                </div>
                            @endif
                        </div>

                        <!-- تفاصيل العرض -->
                        @if($currentOffer && $originalPrice > 0)
                            <div class="relative bg-gradient-to-r from-purple-100 to-pink-100 rounded-lg p-4">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700">السعر الأصلي</span>
                                        <span class="text-gray-600 line-through">{{ number_format($originalPrice, 2) }} د.ل</span>
                                    </div>
                                    @if($savingAmount > 0)
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-700">قيمة التوفير</span>
                                            <span class="text-red-600 font-bold">{{ number_format($savingAmount, 2) }} د.ل</span>
                                        </div>
                                    @endif
                                    <div class="border-t border-gray-200 pt-2">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-900 font-medium">السعر بعد الخصم</span>
                                            <span class="text-green-600 text-xl font-bold">{{ number_format($discountedPrice, 2) }} د.ل</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- زر العمل -->
                        <a href="{{ route('offers-sale.details', ['weddingHall' => $hall]) }}"
                           class="block w-full text-center bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 px-6 rounded-xl hover:from-purple-700 hover:to-pink-700 transition-all duration-300 transform hover:scale-105">
                            عرض التفاصيل
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">لم يتم العثور على عروض نشطة</h3>
                    <p class="mt-2 text-gray-500">يرجى المحاولة مرة أخرى لاحقاً</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
