<?php

namespace App\Filament\HallAdminPanel\Resources\BookingResource\Widgets;

use App\Enum\BookingStatusEnum;
use App\Models\Booking;
use Filament\Forms\Components\TextInput;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class BookingCalendarWidget extends FullCalendarWidget
{
    public Model|string|null $model = Booking::class;

    public function fetchEvents(array $fetchInfo): array
    {
        return Booking::with('weddingHall')->where('status', BookingStatusEnum::Pending->value)
            ->get()
            ->map(function (Booking $task) {
                return [
                    'id' => $task->id,
                    'title' => $task->weddingHall->hall_name,
                    'start' => $task->start_time,
                    'end' => $task->end_time,
                ];
            })
            ->toArray();
    }

    public static function canView(): bool
    {
        return false;
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title')->label('العنوان')
                ->required()
                ->maxLength(255),
            TextInput::make('title')->label('العنوان')
                ->required()
                ->maxLength(255),
        ];
    }
}
