<?php

namespace App\Filament\HallAdminPanel\Pages;

use App\Models\Payment;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;

class WeddingHallPayments extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'المدفوعات';
    protected static ?string $title = 'مدفوعات القاعة';
    protected static ?string $navigationGroup = 'إدارة القاعة';
    protected static string $view = 'filament.pages.wedding-hall-payments';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Payment::query()
                    ->where('wedding_hall_id', auth()->user()->weddingHall->id)
            )
            ->columns([
                Columns\TextColumn::make('booking.id')
                    ->label('رقم الحجز')
                    ->sortable(),
                Columns\TextColumn::make('payment_date')
                    ->label('تاريخ الدفع')
                    ->date()
                    ->sortable(),
                Columns\TextColumn::make('amount')
                    ->label('المبلغ')
                    ->money('LYD')
                    ->sortable(),
                Columns\TextColumn::make('payment_method')
                    ->label('طريقة الدفع')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'cash' => 'نقداً',
                        'credit_card' => 'بطاقة ائتمان',
                        'bank_transfer' => 'تحويل بنكي',
                        default => $state,
                    })
                    ->searchable(),
                Columns\TextColumn::make('payment_type')
                    ->label('نوع الدفع')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'deposit' => 'عربون',
                        'full_payment' => 'دفع كامل',
                        'installment' => 'قسط',
                        default => $state,
                    })
                    ->badge()
                    ->colors([
                        'warning' => 'deposit',
                        'success' => 'full_payment',
                        'info' => 'installment',
                    ]),
                Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'completed' => 'مكتمل',
                        'pending' => 'معلق',
                        'failed' => 'فشل',
                        default => $state,
                    })
                    ->badge()
                    ->colors([
                        'success' => 'completed',
                        'warning' => 'pending',
                        'danger' => 'failed',
                    ]),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'معلق',
                        'completed' => 'مكتمل',
                        'failed' => 'فشل',
                    ]),
                SelectFilter::make('payment_type')
                    ->label('نوع الدفع')
                    ->options([
                        'deposit' => 'عربون',
                        'full_payment' => 'دفع كامل',
                        'installment' => 'قسط',
                    ]),
            ])
            ->defaultSort('payment_date', 'desc');
    }
} 