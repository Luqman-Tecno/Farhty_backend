<x-filament::page>
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
    

        <!-- Content Section -->
        <div class="container mx-auto p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Pricing Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-indigo-50 to-white rounded-xl p-6 shadow-sm border border-indigo-100">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">أسعار الحجز</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">الفترة الصباحية</span>
                                    <span class="text-xl font-bold text-indigo-600">{{ number_format($this->record->shift_prices['day']) }} د.ل</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">الفترة المسائية</span>
                                    <span class="text-xl font-bold text-indigo-600">{{ number_format($this->record->shift_prices['night']) }} د.ل</span>
                                </div>
                                <div class="flex justify-between items-center pt-2 border-t">
                                    <span class="text-gray-600">اليوم كامل</span>
                                    <span class="text-2xl font-bold text-indigo-700">{{ number_format($this->record->shift_prices['full_day']) }} د.ل</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-emerald-50 to-white rounded-xl p-6 shadow-sm border border-emerald-100">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">معلومات إضافية</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">قيمة العربون</span>
                                    <span class="text-xl font-bold text-emerald-600">{{ number_format($this->record->deposit_price) }} د.ل</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">تكلفة الطفل</span>
                                    <span class="text-xl font-bold text-emerald-600">{{ number_format($this->record->price_per_child) }} د.ل</span>
                                </div>
                                <div class="flex justify-between items-center pt-2 border-t">
                                    <span class="text-gray-600">السعة</span>
                                    <span class="text-xl font-bold text-emerald-700">{{ number_format($this->record->capacity) }} شخص</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Amenities Section -->
                    <div class="bg-white rounded-xl p-6 shadow-sm border">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">المرافق والخدمات</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $this->record->amenities) as $amenity)
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">{{ $amenity }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Map Section -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border sticky top-4">
                        <div class="p-4 border-b">
                            <h3 class="text-xl font-semibold text-gray-800">الموقع</h3>
                        </div>
                        <div class="aspect-square">
                            <iframe
                                width="100%"
                                height="100%"
                                frameborder="0"
                                style="border:0"
                                loading="lazy"
                                allowfullscreen
                                referrerpolicy="no-referrer-when-downgrade"
                                src="https://maps.google.com/maps?q={{ $this->record->latitude }},{{ $this->record->longitude }}&hl=ar&z=15&amp;output=embed"
                            ></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .swiper {
            width: 100%;
            height: 100%;
        }
        
        .swiper-slide {
            text-align: center;
            background: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        
        .swiper-button-next,
        .swiper-button-prev {
            color: white !important;
            background: rgba(0, 0, 0, 0.3);
            padding: 2rem;
            border-radius: 50%;
            width: 2rem !important;
            height: 2rem !important;
        }
        
        .swiper-pagination-bullet {
            background: white !important;
            opacity: 0.7;
            width: 10px !important;
            height: 10px !important;
        }
        
        .swiper-pagination-bullet-active {
            opacity: 1;
            background: white !important;
        }
    </style>

    <!-- تحديث قسم السكربت Scripts -->
 #
</x-filament::page>