<?php

namespace App\Filament\HallAdminPanel\Pages;

use App\Enum\BookingShiftEnum;
use App\Enum\BookingStatusEnum;
use App\Models\Booking;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Page;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\View\View;

class BookingsPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static string $view = 'filament.hall-admin-panel.pages.bookings-page';
    protected static ?string $title = 'الحجوزات';
    protected static ?string $navigationGroup = 'الصالة';
    public function table(Table $table): Table
    {
        return $table
            ->query(Booking::query())
            ->columns([
                TextColumn::make('user.name')
                    ->label('المستخدم')
                    ->searchable(),
                TextColumn::make('weddingHall.hall_name')
                    ->label('قاعة الزفاف')
                    ->searchable(),
                TextColumn::make('booking_date')
                    ->label('تاريخ الحجز')
                    ->date()
                    ->sortable(),
                TextColumn::make('shift')
                    ->label('الفترة')
                    ->formatStateUsing(fn(string $state): string => BookingShiftEnum::from($state)->getLabel())
                    ->searchable(),
                BadgeColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn(string $state): string => BookingStatusEnum::from($state)->getLabel())
                    ->colors([
                        'primary' => fn(string $state): bool => $state === BookingStatusEnum::Pending->value,
                        'success' => fn(string $state): bool => $state === BookingStatusEnum::Booked->value,
                        'danger' => fn(string $state): bool => $state === BookingStatusEnum::Cancelled->value,
                        'warning' => fn(string $state): bool => $state === BookingStatusEnum::CHECKOUT->value,
                        'secondary' => fn(string $state): bool => $state === BookingStatusEnum::ON_REVIEW->value,
                    ]),
                TextColumn::make('total_cost')
                    ->label('التكلفة الإجمالية')
                    ->prefix('د.ل')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(BookingStatusEnum::class),
                Filter::make('booking_date')
                    ->form([
                        DatePicker::make('booking_date')
                            ->label('تاريخ الحجز'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data['booking_date'],
                            fn($query) => $query->whereDate('booking_date', $data['booking_date'])
                        );
                    }),
            ],FiltersLayout::AboveContent)
            ->actions([
                Action::make('view')
                    ->label('عرض التفاصيل')
                    ->icon('heroicon-o-eye')
                    ->modalHeading(fn(Booking $record): string => "حجز {$record->user->name}")
                    ->modalContent(fn(Booking $record): View => view('filament.hall-admin-panel.pages.booking-details', ['booking' => $record]))
                    ->modalWidth('lg'),
            ])
            ->defaultSort('booking_date', 'desc')
            ->emptyStateHeading('لا توجد حجوزات')
            ->emptyStateIcon('heroicon-o-calendar');
    }



}
