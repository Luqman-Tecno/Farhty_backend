<x-filament::page>
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="flex flex-col md:flex-row">
            <!-- Image Gallery -->
            <div class="w-full md:w-2/5 lg:w-1/3 relative">
                <div class="swiper-container h-64 md:h-full">
                    <div class="swiper-wrapper">
                        @foreach($this->record->images as $image)
                            <div class="swiper-slide">
                                <img class="w-full h-full object-cover" src="{{ $image }}" alt="{{ $this->record->hall_name }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>

            <!-- Content -->
            <div class="w-full md:w-3/5 lg:w-2/3 p-6 md:p-8 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-3xl font-bold text-gray-800">{{ $this->record->hall_name }}</h2>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">{{ $this->record->city->name_ar }}</span>
                    </div>
                    <p class="text-gray-600 mb-6">{{ $this->record->region }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-lg mb-2">أسعار الحجز</h3>
                            <p class="text-gray-700 mb-1">الفترة الصباحية: <span class="font-bold">{{ number_format($this->record->shift_prices[BookingShiftEnum::DAY->value]) }} ريال</span></p>
                            <p class="text-gray-700 mb-1">الفترة المسائية: <span class="font-bold">{{ number_format($this->record->shift_prices[BookingShiftEnum::NIGHT->value]) }} ريال</span></p>
                            <p class="text-gray-700">اليوم كامل: <span class="font-bold">{{ number_format($this->record->shift_prices[BookingShiftEnum::FULL_DAY->value]) }} ريال</span></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-lg mb-2">معلومات إضافية</h3>
                            <p class="text-gray-700 mb-1">قيمة العربون: <span class="font-bold">{{ number_format($this->record->deposit_price) }} ريال</span></p>
                            <p class="text-gray-700 mb-1">تكلفة الطفل: <span class="font-bold">{{ number_format($this->record->price_per_child) }} ريال</span></p>
                            <p class="text-gray-700">السعة: <span class="font-bold">{{ $this->record->capacity }} شخص</span></p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-2">المرافق والخدمات</h3>
                        <p class="text-gray-700">{{ $this->record->amenities }}</p>
                    </div>
                </div>

                <div class="flex space-x-3 rtl:space-x-reverse">
                    <x-filament::button
                        wire:click="edit"
                        color="primary"
                        class="flex-1"
                    >
                        تعديل
                    </x-filament::button>
                    <x-filament::button
                        wire:click="delete"
                        color="danger"
                        class="flex-1"
                    >
                        حذف
                    </x-filament::button>
                </div>
            </div>
        </div>
    </div>
</x-filament::page>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.swiper-container', {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
</script>
