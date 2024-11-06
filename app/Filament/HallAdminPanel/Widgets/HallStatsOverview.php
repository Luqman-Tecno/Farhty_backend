<?php

namespace App\Filament\HallAdminPanel\Widgets;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Service;
use App\Models\WeddingHall;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class HallStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $hallId = auth()->user()->weddingHall->first()->id;

        return [
            Stat::make('إجمالي الحجوزات', Booking::where('wedding_hall_id', $hallId)->count())
                ->description('عدد الحجوزات الكلي')
                ->descriptionIcon('heroicon-m-calendar')
                ->chart([7, 4, 6, 8, 5, 9, 10])
                ->color('primary'),

            Stat::make('إجمالي المدفوعات', 'LYD ' . number_format(Payment::where('wedding_hall_id', $hallId)
                ->sum('amount'), 2))
                ->description('المبلغ الإجمالي للمدفوعات')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('الحجوزات المعلقة', Booking::where('wedding_hall_id', $hallId)
                ->where('status', 'pending')->count())
                ->description('عدد الحجوزات قيد الانتظار')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
} 