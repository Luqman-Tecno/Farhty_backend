<div>
    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- رسائل الخطأ -->
            @if($errorMessage)
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-xl p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-400 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $errorMessage }}</span>
                    </div>
                </div>
            @endif

            <!-- رسائل النجاح -->
            @if(session()->has('message'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-400 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('message') }}</span>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- رأس الصفحة -->
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-8 text-white">
                    <h2 class="text-2xl font-bold">تأكيد حجز القاعة</h2>
                    <p class="mt-2 text-purple-100">{{ $weddingHall->hall_name }}</p>
                </div>

                <!-- تفاصيل الحجز -->
                <div class="p-6 space-y-8">
                    <!-- التاريخ المختار -->
                    <div class="calendar-info mb-6">
                        <div class="bg-purple-50 rounded-xl p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="font-medium text-purple-900">التاريخ المختار:</span>
                                </div>
                                <span class="text-purple-700 font-bold">
                                    {{ Carbon\Carbon::parse($selectedDate)->locale('ar')->translatedFormat('l j F Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" wire:model="selectedDate">

                    <form wire:submit.prevent="submit" class="space-y-6">
                        <!-- اختيار الفترة -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">الفترة</label>
                            <div class="grid grid-cols-3 gap-3">
                                @foreach(['day' => 'صباحي', 'night' => 'مسائي', 'full_day' => 'يوم كامل'] as $value => $label)
                                    @if(in_array($value, $this->availableShifts))
                                        <label class="relative flex">
                                            <input type="radio" wire:model.live="shift" value="{{ $value }}" 
                                                   class="peer sr-only" name="shift">
                                            <div class="w-full p-3 text-center rounded-xl border cursor-pointer 
                                                        peer-checked:bg-purple-100 peer-checked:border-purple-500 
                                                        peer-checked:text-purple-900 hover:bg-gray-50">
                                                {{ $label }}
                                            </div>
                                        </label>
                                    @else
                                        <div class="w-full p-3 text-center rounded-xl border bg-gray-100 text-gray-400 cursor-not-allowed">
                                            {{ $label }}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @error('shift') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- عدد الأطفال -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">عدد الأطفال</label>
                            <input type="number" wire:model.live="childrenCount" min="0"
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            @error('childrenCount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- الخدمات الإضافية -->
                        @if($weddingHall->services && $weddingHall->services->isNotEmpty())
                            <div class="space-y-4">
                                <h3 class="font-medium text-gray-900">الخدمات الإضافية</h3>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    @foreach($weddingHall->services as $service)
                                        <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl cursor-pointer hover:bg-gray-100">
                                            <div class="flex items-center gap-3">
                                                <input type="checkbox" 
                                                       wire:model.live="additionalServices.{{ $service->id }}"
                                                       class="rounded border-gray-300 text-purple-600 shadow-sm 
                                                              focus:border-purple-500 focus:ring-purple-500">
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $service->name }}</p>
                                                    <p class="text-sm text-gray-500">{{ number_format($service->price, 2) }} د.ل</p>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- الملاحظات -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">ملاحظات إضافية</label>
                            <textarea wire:model="notes" rows="3"
                                      class="w-full rounded-xl border-gray-300 shadow-sm 
                                             focus:border-purple-500 focus:ring-purple-500"></textarea>
                            @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- ملخص السعر -->
                        @if(!empty($priceBreakdown))
                            <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                                <h3 class="font-bold text-gray-900">تفاصيل السعر</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">
                                            سعر القاعة
                                            @if($priceBreakdown['has_offer'])
                                                <span class="text-green-600 text-sm">(سعر العرض)</span>
                                            @endif
                                        </span>
                                        <span class="font-medium">{{ number_format($priceBreakdown['base_price'], 2) }} د.ل</span>
                                    </div>
                                    
                                    @if($priceBreakdown['children_cost'] > 0)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">تكلفة الأطفال</span>
                                            <span class="font-medium">{{ number_format($priceBreakdown['children_cost'], 2) }} د.ل</span>
                                        </div>
                                    @endif
                                    
                                    @if($priceBreakdown['services_cost'] > 0)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">الخدمات الإضافية</span>
                                            <span class="font-medium">{{ number_format($priceBreakdown['services_cost'], 2) }} د.ل</span>
                                        </div>
                                    @endif

                                    <div class="pt-4 border-t border-gray-200">
                                        <div class="flex justify-between">
                                            <span class="font-bold text-gray-900">المجموع الكلي</span>
                                            <span class="font-bold text-purple-600">{{ number_format($priceBreakdown['total'], 2) }} د.ل</span>
                                        </div>
                                    </div>

                                    <div class="bg-purple-50 p-4 rounded-lg mt-4">
                                        <div class="flex justify-between">
                                            <span class="font-medium text-purple-900">العربون المطلوب (30%)</span>
                                            <span class="font-bold text-purple-900">{{ number_format($priceBreakdown['deposit_required'], 2) }} د.ل</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- زر التأكيد مع حالة التحميل -->
                        <button type="submit"
                                class="w-full bg-purple-600 text-white py-4 px-6 rounded-xl font-medium
                                       hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 
                                       focus:ring-offset-2 transition-colors duration-200 relative"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-75">
                            <span wire:loading.remove>تأكيد الحجز</span>
                            <span wire:loading>جاري المعالجة...</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
