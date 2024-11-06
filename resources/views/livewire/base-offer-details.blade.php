<div class="container mx-auto p-4 lg:p-8" dir="rtl">
    @if($weddingHall)
        <!-- ... الأقسام السابقة ... -->

        <!-- قسم التقويم -->
        <div class="mt-10 bg-gradient-to-br from-purple-50 to-purple-100/50 p-8 rounded-2xl border border-purple-100">
            <h3 class="text-2xl font-bold text-purple-900 mb-6">مواعيد الحجز المتاحة</h3>
            
            <div class="calendar-grid">
                <!-- أيام الأسبوع -->
                <div class="grid grid-cols-7 gap-2 mb-4">
                    @foreach(['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'] as $day)
                        <div class="text-center font-bold text-purple-900">{{ $day }}</div>
                    @endforeach
                </div>

                <!-- التقويم -->
                <div class="grid grid-cols-7 gap-2">
                    @foreach($calendarDays as $day)
                        @if(!isset($day['padding']))
                            <div 
                                class="relative p-4 rounded-lg cursor-pointer transition-all duration-200
                                {{ $day['available'] ? 
                                    ($day['is_weekend'] ? 'bg-purple-100 hover:bg-purple-200' : 'bg-green-100 hover:bg-green-200') : 
                                    'bg-red-100 cursor-not-allowed' }}"
                                @if($day['available'])
                                    wire:click="selectDate('{{ $day['date'] }}')"
                                @endif
                            >
                                <div class="text-center">
                                    <span class="block text-lg font-semibold">
                                        {{ \Carbon\Carbon::parse($day['date'])->format('d') }}
                                    </span>
                                    @if($day['available'])
                                        <span class="text-xs text-gray-600">
                                            {{ count($day['shifts']) }} فترات متاحة
                                        </span>
                                    @else
                                        <span class="text-xs text-red-600">محجوز</span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="p-4"></div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- زر الحجز -->
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
    @else
        <div class="text-center py-12">
            <div class="bg-red-50 p-6 rounded-xl">
                <h3 class="text-xl font-bold text-red-600 mb-2">عذراً</h3>
                <p class="text-gray-600">لم يتم العثور على القاعة المطلوبة</p>
            </div>
        </div>
    @endif
</div> 