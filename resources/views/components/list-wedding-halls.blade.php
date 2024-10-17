<x-filament::page>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-black p-6">
            <h2 class="text-3xl font-bold mb-2">{{ $this->record->hall_name }}</h2>
            <p class="text-xl">{{ $this->record->city->name_ar }} - {{ $this->record->region }}</p>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-6">
            <!-- Hall Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Pricing Information -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-2xl font-semibold mb-4 dark:text-white">معلومات الحجز</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white dark:bg-gray-600 p-4 rounded-md shadow">
                            <p class="font-semibold text-gray-600 dark:text-gray-300">الفترة الصباحية</p>
                            <p class="text-2xl text-indigo-600 dark:text-indigo-400 font-bold">{{ number_format($this->record->shift_prices[\App\Enum\BookingShiftEnum::DAY->value]) }} دينار</p>
                        </div>
                        <div class="bg-white dark:bg-gray-600 p-4 rounded-md shadow">
                            <p class="font-semibold text-gray-600 dark:text-gray-300">الفترة المسائية</p>
                            <p class="text-2xl text-indigo-600 dark:text-indigo-400 font-bold">{{ number_format($this->record->shift_prices[\App\Enum\BookingShiftEnum::NIGHT->value]) }} دينار</p>
                        </div>
                        <div class="bg-white dark:bg-gray-600 p-4 rounded-md shadow">
                            <p class="font-semibold text-gray-600 dark:text-gray-300">اليوم كامل</p>
                            <p class="text-2xl text-indigo-600 dark:text-indigo-400 font-bold">{{ number_format($this->record->shift_prices[\App\Enum\BookingShiftEnum::FULL_DAY->value]) }} دينار</p>
                        </div>
                        <div class="bg-white dark:bg-gray-600 p-4 rounded-md shadow">
                            <p class="font-semibold text-gray-600 dark:text-gray-300">قيمة العربون</p>
                            <p class="text-2xl text-indigo-600 dark:text-indigo-400 font-bold">{{ number_format($this->record->deposit_price) }} دينار</p>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-2xl font-semibold mb-4 dark:text-white">معلومات إضافية</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="font-semibold text-gray-600 dark:text-gray-300">تكلفة الطفل الواحد</p>
                            <p class="text-xl text-indigo-600 dark:text-indigo-400">{{ number_format($this->record->price_per_child) }} دينار</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-600 dark:text-gray-300">السعة</p>
                            <p class="text-xl dark:text-white">{{ $this->record->capacity }} شخص</p>
                        </div>
                    </div>
                </div>

                <!-- Amenities -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-2xl font-semibold mb-4 dark:text-white">المرافق والخدمات</h3>
                    <p class="text-gray-700 dark:text-gray-300">{{ $this->record->amenities }}</p>
                </div>
            </div>

            <!-- Map -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 h-full">
                    <h3 class="text-2xl font-semibold mb-4 dark:text-white">الموقع</h3>
                    <div class="aspect-w-1 aspect-h-1">
                        <iframe
                            width="100%"
                            height="100%"
                            frameborder="0"
                            scrolling="no"
                            marginheight="0"
                            marginwidth="0"
                            src="https://maps.google.com/maps?q={{ $this->record->latitude }},{{ $this->record->longitude }}&hl=ar&z=14&amp;output=embed"
                        ></iframe>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-filament::page>
