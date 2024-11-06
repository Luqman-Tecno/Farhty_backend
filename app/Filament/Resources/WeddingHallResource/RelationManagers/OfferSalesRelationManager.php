<?php

namespace App\Filament\Resources\WeddingHallResource;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class OfferSalesRelationManager extends RelationManager
{
    protected static string $relationship = 'offerSales';
    protected static ?string $title = 'العروض';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sale_price')
                    ->label('سعر العرض')
                    ->required()
                    ->numeric()
                    ->prefix('د.ل'),
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('تاريخ البداية')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('تاريخ النهاية')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('وصف العرض'),
                Forms\Components\Toggle::make('status')
                    ->label('حالة العرض')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sale_price')
                    ->label('سعر العرض')
                    ->money('lyd'),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('تاريخ البداية')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('تاريخ النهاية')
                    ->dateTime(),
                Tables\Columns\IconColumn::make('status')
                    ->label('الحالة')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
} 