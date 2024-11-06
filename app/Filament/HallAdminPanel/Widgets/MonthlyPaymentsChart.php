<?php

namespace App\Filament\HallAdminPanel\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MonthlyPaymentsChart extends ChartWidget
{
    protected static ?string $heading = 'المدفوعات الشهرية';

    protected function getData(): array
    {
        $hallId = auth()->user()->weddingHall->first()->id;
        
        $payments = Payment::where('wedding_hall_id', $hallId)
            ->select(
                DB::raw('sum(amount) as total'),
                DB::raw("DATE_FORMAT(payment_date,'%M') as month"),
                DB::raw("MONTH(payment_date) as month_number")
            )
            ->whereYear('payment_date', date('Y'))
            ->groupBy('month', 'month_number')
            ->orderBy('month_number')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'المدفوعات',
                    'data' => $payments->pluck('total')->toArray(),
                    'borderColor' => '#6366F1',
                    'fill' => false,
                ]
            ],
            'labels' => $payments->pluck('month')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
} 