<div class="calendar-wrapper" wire:key="calendar-{{ $currentMonth }}">
    <!-- شريط التنقل بين الأشهر -->
    <div class="month-navigation">
        <!-- زر الشهر التالي (يسار في العربية) -->
        <button wire:click="nextMonth" class="nav-btn">
            
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        
        <h4 class="month-title">
            {{ \Carbon\Carbon::parse($currentMonth)->locale('ar')->translatedFormat('F Y') }}
        </h4>
        
        <!-- زر الشهر السابق (يمين في العربية) -->
        <button wire:click="previousMonth" class="nav-btn">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
    </div>

    <!-- شبكة التقويم -->
    <div class="calendar-grid-container">
        <!-- أيام الأسبوع -->
        <div class="weekdays-grid">
            @foreach(['أحد', 'اثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة', 'سبت'] as $day)
                <div class="weekday">{{ $day }}</div>
            @endforeach
        </div>

        <!-- أيام الشهر -->
        <div class="days-grid">
            @foreach($calendarDays as $day)
                @if($day['padding'])
                    <div class="day-cell padding"></div>
                @else
                    <div 
                        wire:key="day-{{ $day['date'] }}"
                        class="day-cell {{ $day['available'] ? 'available' : 'unavailable' }} 
                               {{ $day['is_weekend'] ? 'weekend' : '' }}
                               {{ $selectedDate === $day['date'] ? 'selected' : '' }}"
                        @if($day['available'])
                            wire:click="selectDate('{{ $day['date'] }}')"
                        @endif
                    >
                        <div class="day-content">
                            <span class="day-number">
                                {{ \Carbon\Carbon::parse($day['date'])->format('d') }}
                            </span>
                            @if($day['available'])
                                <span class="shifts-count">
                                    {{ count($day['shifts']) }} فترات
                                </span>
                            @else
                                <span class="unavailable-label">محجوز</span>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div> 