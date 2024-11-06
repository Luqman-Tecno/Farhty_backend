<?php

namespace App\Filament\HallAdminPanel\Widgets;

use App\Enum\BookingStatusEnum;
use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class BookingsChart extends ChartWidget
{
    protected static ?string $heading = 'الحجوزات حسب الحالة';

    protected function getData(): array
    {
        $hallId = auth()->user()->weddingHall->first()->id;
        
        $bookingStats = Booking::where('wedding_hall_id', $hallId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'الحجوزات',
                    'data' => $bookingStats->pluck('total')->toArray(),
                    'backgroundColor' => ['#10B981', '#F59E0B', '#EF4444'],
                ]
            ],
            'labels' => BookingStatusEnum::getLabelsForValues($bookingStats->pluck('status')->toArray()),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
} 