<div class="min-h-screen bg-gray-50" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">استكشف القاعات</h1>
            <p class="mt-2 text-gray-600">اختر القاعة المثالية لمناسبتك من خلال خيارات البحث المتقدمة</p>
        </div>

        <!-- Filters Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
            <!-- Search Filters -->
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- City Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-purple-900">المدينة</label>
                        <select
                            wire:model="selectedShift"
                            class="w-full rounded-xl border-purple-200 bg-white/70 focus:border-purple-500 focus:ring-purple-500 py-3"
                        >
                            <option value="">كل المدن</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Region Filter -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">المنطقة</label>
                        <input wire:model.debounce.300ms="region"
                               type="text"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                               placeholder="ابحث عن المنطقة">
                    </div>

                    <!-- Capacity Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-purple-900">السعة</label>
                        <select
                            wire:model.live="capacity"
                            class="w-full rounded-xl border-purple-200 bg-white/70 focus:border-purple-500 focus:ring-purple-500 py-3"
                        >
                            <option value="">عدد الاشخاص </option>
                            @foreach([100, 150, 200, 250, 300, 400] as $cap)
                                <option value="{{ $cap }}">{{ $cap }} شخص</option>
                            @endforeach
                        </select>
                    </div>


                </div>

                <!-- Sort Options -->
                <div class="flex flex-wrap gap-4 pt-4 border-t">
                    <button wire:click="sortByPrice"
                            class="inline-flex items-center px-6 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                                   {{ $sortField === 'shift_prices' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        فرز حسب السعر
                    </button>

                    <button wire:click="sortByCapacity"
                            class="inline-flex items-center px-6 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                                   {{ $sortField === 'capacity' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        فرز حسب السعة
                    </button>
                </div>
            </div>
        </div>

        <!-- Wedding Halls Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($halls as $hall)
                <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <!-- Image Container -->
                    <div class="relative aspect-[16/9] overflow-hidden">
                        @if($hall->images)
                            <img src="{{ asset( \Illuminate\Support\Facades\Storage::url($hall->images[0]) ?? 'images/default-hall.jpg') }}"
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                 alt="{{ $hall->hall_name }}">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">لا توجد صورة</span>
                            </div>
                        @endif

                        <!-- Capacity Badge -->
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-medium text-gray-700">
                            {{ $hall->capacity }} شخص
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-start">
                            <h3 class="text-xl font-bold text-gray-900">{{ $hall->hall_name }}</h3>
                            <div class="text-lg font-bold text-purple-600">
                                @if($hall->shift_prices)

                                    {{ number_format($hall->shift_prices['full_day'] ?? 0, 2) }} د.ل
                                @else
                                    السعر غير متوفر
                                @endif
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $hall->city->name_ar ?? '' }} - {{ $hall->region }}
                            </div>

                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                عربون: {{ $hall->deposit_price ?? 0 }} د.ك
                            </div>
                        </div>

                        <a href="{{route('offers.details',['weddingHall' => $hall] )}}"
                           class="block w-full text-center bg-purple-600 text-white py-3 px-6 rounded-xl hover:bg-purple-700 transition-colors duration-200"
                           wire:navigate>
                            عرض التفاصيل
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">لم يتم العثور على قاعات</h3>
                    <p class="mt-2 text-gray-500">جرب تغيير معايير البحث للحصول على نتائج مختلفة</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
