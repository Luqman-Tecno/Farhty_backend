<?php

namespace App\Filament\HallAdminPanel\Pages;

use App\Models\Booking;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class BookingNotes extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'ملاحظات الحجوزات';
    protected static ?string $title = 'ملاحظات الحجوزات';
    protected static string $view = 'filament.pages.booking-notes';

    public function table(Table $table): Table
    {
        return $table
            ->query(Booking::query()->whereNotNull('notes'))
            ->columns([
                TextColumn::make('user.name')
                    ->label('اسم المستخدم')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('booking_date')
                    ->label('تاريخ الحجز')
                    ->date()
                    ->sortable(),
                TextColumn::make('notes')
                    ->label('الملاحظات')
                    ->wrap()
                    ->searchable(),
            ]);
    }
} 