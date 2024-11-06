<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-3">استكشف أفضل القاعات</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">اختر القاعة المثالية لمناسبتك من خلال مجموعة متنوعة من الخيارات المميزة</p>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 mb-12 overflow-hidden">
            <div class="p-8">
                <!-- Main Filters -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <!-- City Filter -->
                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-gray-800">المدينة</label>
                        <div class="relative">
                            <select
                                wire:model.live="cityId"
                                class="w-full rounded-xl border-gray-200 bg-gray-50 py-3.5 pl-4 pr-10 text-sm focus:border-purple-500 focus:ring-purple-500"
                            >
                                <option value="">جميع المدن</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name_ar }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Region Filter -->
                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-gray-800">المنطقة</label>
                        <div class="relative">
                            <input 
                                wire:model.live.debounce.300ms="region"
                                type="text"
                                class="w-full rounded-xl border-gray-200 bg-gray-50 py-3.5 pl-4 pr-10 text-sm focus:border-purple-500 focus:ring-purple-500"
                                placeholder="ابحث عن المنطقة"
                            >
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Capacity Filter -->
                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-gray-800">السعة</label>
                        <div class="relative">
                            <select
                                wire:model.live="capacity"
                                class="w-full rounded-xl border-gray-200 bg-gray-50 py-3.5 pl-4 pr-10 text-sm focus:border-purple-500 focus:ring-purple-500"
                            >
                                <option value="">جميع السعات</option>
                                @foreach([100, 150, 200, 250, 300, 400] as $cap)
                                    <option value="{{ $cap }}">{{ $cap }} شخص وأكثر</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="flex flex-wrap items-center gap-4 pt-6 border-t border-gray-100">
                    <span class="text-sm font-semibold text-gray-700">ترتيب حسب:</span>
                    <button 
                        wire:click="sortByPrice"
                        class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                               {{ $sortField === 'shift_prices' ? 'bg-purple-100 text-purple-800 ring-1 ring-purple-400' : 'bg-gray-50 text-gray-700 hover:bg-gray-100' }}"
                    >
                        <svg class="w-4 h-4 ml-2 transition-transform duration-200" 
                             fill="none" 
                             stroke="currentColor" 
                             viewBox="0 0 24 24"
                             style="{{ $sortField === 'shift_prices' && $sortDirection === 'desc' ? 'transform: rotate(180deg)' : '' }}"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        السعر
                    </button>

                    <button 
                        wire:click="sortByCapacity"
                        class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                               {{ $sortField === 'capacity' ? 'bg-purple-100 text-purple-800 ring-1 ring-purple-400' : 'bg-gray-50 text-gray-700 hover:bg-gray-100' }}"
                    >
                        <svg class="w-4 h-4 ml-2 transition-transform duration-200" 
                             fill="none" 
                             stroke="currentColor" 
                             viewBox="0 0 24 24"
                             style="{{ $sortField === 'capacity' && $sortDirection === 'desc' ? 'transform: rotate(180deg)' : '' }}"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        السعة
                    </button>
                </div>
            </div>
        </div>

        <!-- Wedding Halls Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @if(count($halls) > 0)
                @foreach($halls as $hall)
                    @php
                        $currentOffer = $hall->getCurrentOffer();
                        $originalPrice = $hall->getOriginalPrice();
                        $discountedPrice = $currentOffer?->sale_price;
                        $discountPercentage = $currentOffer?->calculateDiscountPercentage();
                        $savingAmount = $currentOffer?->getSavingAmount();
                        $offerEndDate = $currentOffer?->end_date;
                    @endphp

                    <div wire:key="hall-{{ $hall->id }}" 
                         class="group bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl">
                        <!-- Image Container -->
                        <div class="relative aspect-[16/9] overflow-hidden bg-gray-100">
                            @if($hall->images && is_array($hall->images) && count($hall->images) > 0)
                                <img src="{{ asset(Storage::url($hall->images[0])) }}"
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                     alt="{{ $hall->hall_name }}"
                                     loading="lazy">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif

                            <!-- Badges -->
                            <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-medium text-gray-700 shadow-sm">
                                {{ $hall->capacity }} شخص
                            </div>

                            @if($currentOffer)
                                <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    خصم {{ number_format($discountPercentage, 0) }}%
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-6 space-y-6">
                            <div class="flex justify-between items-start">
                                <h3 class="text-xl font-bold text-gray-900">{{ $hall->hall_name }}</h3>
                                <div class="text-lg font-bold">
                                    @if($currentOffer)
                                        <div class="flex flex-col items-end">
                                            <span class="text-lg line-through text-gray-400">{{ number_format($originalPrice, 2) }} د.ل</span>
                                            <span class="text-xl font-bold text-green-600">{{ number_format($discountedPrice, 2) }} د.ل</span>
                                        </div>
                                    @else
                                        <span class="text-purple-600">
                                            {{ number_format($hall->shift_prices['full_day'] ?? 0, 2) }} د.ل
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="space-y-3">
                                <!-- Location -->
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $hall->city->name_ar ?? '' }} - {{ $hall->region }}
                                </div>

                                <!-- Deposit -->
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    عربون: {{ number_format($hall->deposit_price ?? 0, 0) }} د.ل
                                </div>

                                @if($offerEndDate)
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        ينتهي العرض: {{ $offerEndDate->format('Y-m-d') }}
                                    </div>
                                @endif
                            </div>

                            @if($currentOffer)
                                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-4 space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700">قيمة التوفير</span>
                                        <span class="text-red-600 font-bold">{{ number_format($savingAmount, 2) }} د.ل</span>
                                    </div>
                                </div>
                            @endif

                            <a href="{{ route('offers.details', ['weddingHall' => $hall]) }}"
                               class="block w-full text-center bg-purple-600 text-white py-3 px-6 rounded-xl hover:bg-purple-700 transition-colors duration-200 font-medium"
                               wire:navigate>
                                عرض التفاصيل
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div wire:key="no-results" class="col-span-1 md:col-span-2 lg:col-span-3">
                    <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100">
                        <div class="max-w-sm mx-auto">
                            <svg class="w-20 h-20 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <h3 class="mt-6 text-lg font-semibold text-gray-900">لم يتم العثور على قاعات</h3>
                            <p class="mt-2 text-gray-500">جرب تغيير معايير البحث للحصول على نتائج مختلفة</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
