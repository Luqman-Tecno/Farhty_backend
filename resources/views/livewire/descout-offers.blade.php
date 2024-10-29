<div class="min-h-screen bg-gray-50" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">عروض وتخفيضات</h1>
            <p class="mt-2 text-gray-600">اكتشف أفضل العروض والتخفيضات على قاعات الأفراح</p>
        </div>

        <!-- Filters Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
            <!-- Search Filters -->
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- City Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-purple-900">المدينة</label>
                        <select
                            wire:model="selectedCity"
                            class="w-full rounded-xl border-purple-200 bg-white/70 focus:border-purple-500 focus:ring-purple-500 py-3"
                        >
                            <option value="">كل المدن</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Discount Range Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-purple-900">نسبة الخصم</label>
                        <select
                            wire:model.live="discountRange"
                            class="w-full rounded-xl border-purple-200 bg-white/70 focus:border-purple-500 focus:ring-purple-500 py-3"
                        >
                            <option value="">كل العروض</option>
                            <option value="10">10% وأكثر</option>
                            <option value="20">20% وأكثر</option>
                            <option value="30">30% وأكثر</option>
                            <option value="50">50% وأكثر</option>
                        </select>
                    </div>

                    <!-- Date Range Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-purple-900">تاريخ العرض</label>
                        <input
                            wire:model="offerDate"
                            type="date"
                            class="w-full rounded-xl border-purple-200 bg-white/70 focus:border-purple-500 focus:ring-purple-500 py-3"
                        >
                    </div>

                    <!-- Price Range Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-purple-900">نطاق السعر</label>
                        <select
                            wire:model.live="priceRange"
                            class="w-full rounded-xl border-purple-200 bg-white/70 focus:border-purple-500 focus:ring-purple-500 py-3"
                        >
                            <option value="">كل الأسعار</option>
                            <option value="1000">أقل من 1000 د.ل</option>
                            <option value="2000">أقل من 2000 د.ل</option>
                            <option value="3000">أقل من 3000 د.ل</option>
                        </select>
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="flex flex-wrap gap-4 pt-4 border-t">
                    <button wire:click="sortByDiscount"
                            class="inline-flex items-center px-6 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                                   {{ $sortField === 'discount' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        فرز حسب نسبة الخصم
                    </button>

                    <button wire:click="sortByPrice"
                            class="inline-flex items-center px-6 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                                   {{ $sortField === 'price' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        فرز حسب السعر
                    </button>

                    <button wire:click="sortByDate"
                            class="inline-flex items-center px-6 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                                   {{ $sortField === 'date' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        فرز حسب التاريخ
                    </button>
                </div>
            </div>
        </div>

        <!-- Offers Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($offers as $offer)
                <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <!-- Image Container -->
                    <div class="relative aspect-[16/9] overflow-hidden">
                        @if($offer->hall->images)
                            <img src="{{ asset( \Illuminate\Support\Facades\Storage::url($offer->hall->images[0]) ?? 'images/default-hall.jpg') }}"
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                 alt="{{ $offer->hall->hall_name }}">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">لا توجد صورة</span>
                            </div>
                        @endif

                        <!-- Discount Badge -->
                        <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                            خصم {{ $offer->discount_percentage }}%
                        </div>

                        <!-- Valid Until Badge -->
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-medium text-gray-700">
                            ينتهي في {{ $offer->end_date }}
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-start">
                            <h3 class="text-xl font-bold text-gray-900">{{ $offer->hall->hall_name }}</h3>
                            <div class="text-right">
                                <div class="text-lg font-bold text-red-600">
                                    {{ number_format($offer->discounted_price, 2) }} د.ل
                                </div>
                                <div class="text-sm line-through text-gray-400">
                                    {{ number_format($offer->original_price, 2) }} د.ل
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $offer->hall->city->name_ar ?? '' }} - {{ $offer->hall->region }}
                            </div>

                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                تاريخ العرض: {{ $offer->start_date }} إلى {{ $offer->end_date }}
                            </div>

                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                عربون: {{ $offer->deposit_price ?? 0 }} د.ل
                            </div>
                        </div>

                        <a href="{{ route('offers.details', ['weddingHall' => $offer]) }}"
                           class="block w-full text-center bg-purple-600 text-white py-3 px-6 rounded-xl hover:bg-purple-700 transition-colors duration-200"
                           wire:navigate>
                            تفاصيل الصالة
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">لا توجد عروض متاحة</h3>
                    <p class="mt-2 text-gray-500">جرب تغيير معايير البحث للحصول على نتائج مختلفة</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
