<div>
    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-b from-gray-50 to-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="max-w-5xl mx-auto p-8 font-cairo">
                    <!-- Header Section -->
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">حجز القاعة</h2>
                        <p class="text-gray-600">اختر التاريخ والخدمات المناسبة لحجزك</p>
                    </div>

                    <!-- Alert Messages -->
                    @if (session()->has('message'))
                        <div class="bg-green-50 border-r-4 border-green-500 p-4 rounded-2xl flex items-center mb-6 animate-fadeIn">
                            <svg class="h-6 w-6 text-green-500 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <p class="text-green-700">{{ session('message') }}</p>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="bg-red-50 border-r-4 border-red-500 p-4 rounded-2xl flex items-center mb-6 animate-fadeIn">
                            <svg class="h-6 w-6 text-red-500 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <p class="text-red-700">{{ session('error') }}</p>
                        </div>
                    @endif

                    <!-- Booking Form -->
                    <form wire:submit.prevent="submit" class="space-y-8">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Booking Date -->
                                <div class="form-group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">تاريخ الحجز</label>
                                    <div class="relative">
                                        <input type="date" wire:model="bookingDate"
                                               class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
                                        @error('bookingDate') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Shift Selection -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-purple-900">الفترة</label>
                                    <select
                                        wire:model="shift"
                                        class="w-full rounded-xl border-purple-200 bg-white/70 focus:border-purple-500 focus:ring-purple-500 py-3"
                                    >
                                        <option value="">اختر الفترة</option>
                                        <option value="day">صباحي</option>
                                        <option value="night">مسائي</option>
                                        <option value="full_day">يوم كامل</option>
                                    </select>
                                    @error('shift') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Children Count -->
                            <div class="mt-8">
                                <label class="block text-sm font-bold text-gray-700 mb-2">عدد الأطفال</label>
                                <input type="number" wire:model="childrenCount" min="0"
                                       class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
                                @error('childrenCount') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Additional Services -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-6">الخدمات الإضافية</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($weddingHall->services as $service)
                                    <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                        <input type="number"
                                               wire:model="additionalServices.{{ $service->id }}"
                                               min="0"
                                               class="w-24 px-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                        <span class="mr-4 text-gray-700 font-medium">{{ $service->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Notes & Special Requests -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="form-group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">ملاحظات</label>
                                    <textarea wire:model="notes" rows="4"
                                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm"></textarea>
                                    @error('notes') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">طلبات خاصة</label>
                                    <textarea wire:model="specialRequests" rows="4"
                                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm"></textarea>
                                    @error('specialRequests') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        @if(!empty($priceBreakdown))
                            <div class="bg-blue-50 rounded-2xl p-8 border border-blue-100">
                                <h3 class="text-xl font-bold text-gray-900 mb-6">تفاصيل السعر</h3>
                                <div class="space-y-4">
                                    <div class="flex justify-between py-3 border-b border-blue-100">
                                        <span class="text-gray-600">سعر القاعة الأساسي</span>

                                        <span class="font-bold text-gray-900">{{ number_format($priceBreakdown['base_price'], 2) }} ريال</span>
                                    </div>
                                    <div class="flex justify-between py-3 border-b border-blue-100">
                                        <span class="text-gray-600">تكلفة الأطفال</span>
                                        <span class="font-bold text-gray-900">{{ number_format($priceBreakdown['children_cost'], 2) }} ريال</span>
                                    </div>
                                    <div class="flex justify-between py-3 border-b border-blue-100">
                                        <span class="text-gray-600">الخدمات الإضافية</span>
                                        <span class="font-bold text-gray-900">{{ number_format($priceBreakdown['services_cost'], 2) }} ريال</span>
                                    </div>
                                    <div class="flex justify-between py-3 border-b border-blue-100">
                                        <span class="text-gray-600">الضريبة</span>
                                        <span class="font-bold text-gray-900">{{ number_format($priceBreakdown['tax'], 2) }} ريال</span>
                                    </div>
                                    <div class="flex justify-between py-4 text-lg">
                                        <span class="font-bold text-gray-900">المجموع الكلي</span>
                                        <span class="font-bold text-blue-600">{{ number_format($priceBreakdown['total_cost'], 2) }} ريال</span>
                                    </div>
                                    <div class="flex justify-between py-4 bg-green-50 rounded-xl px-6">
                                        <span class="font-bold text-green-800">العربون المطلوب</span>
                                        <span class="font-bold text-green-600">{{ number_format($priceBreakdown['deposit_required'], 2) }} ريال</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Submit Button -->
                        <button
                                type="submit"
                                class="w-full py-4 px-6 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-xl shadow-lg transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-[1.02]">
                            تأكيد الحجز
                        </button>
                    </form>

                    <!-- Available Dates Calendar -->
                    <div class="mt-16">
                        <h3 class="text-xl font-bold text-gray-900 mb-8">التواريخ المتاحة</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            @foreach($schedule as $date => $shifts)
                                <div class="p-4 rounded-xl border border-gray-200 hover:border-blue-500 hover:shadow-md transition-all bg-white">
                                    <div class="text-sm font-bold text-gray-800 mb-3">
                                        {{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}
                                    </div>
                                    <div class="space-y-2">
                                        @foreach($shifts as $shift)
                                            <div class="text-xs py-1 px-2 bg-gray-50 rounded-md text-gray-600">
                                                @switch($shift)
                                                    @case('day')
                                                        صباحاً
                                                        @break
                                                    @case('night')
                                                        مساءً
                                                        @break
                                                    @case('full_day')
                                                        يوم كامل
                                                        @break
                                                @endswitch
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
