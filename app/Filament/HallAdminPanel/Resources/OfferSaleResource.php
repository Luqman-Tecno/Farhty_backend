<?php

namespace App\Filament\HallAdminPanel\Resources;

use App\Filament\HallAdminPanel\Resources\OfferSaleResource\Pages;
use App\Models\OfferSale;
use App\Models\WeddingHall;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfferSaleResource extends Resource
{
    protected static ?string $model = OfferSale::class;

    protected static ?string $navigationLabel = 'إدارة العروض';
    protected static ?string $modelLabel = 'عرض';
    protected static ?string $pluralModelLabel = 'العروض';
    protected static ?string $navigationGroup = 'الصالة';
    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $slug = 'offer-sales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('wedding_hall_id')
                    ->label('القاعة')
                    ->options(WeddingHall::where('user_id', auth()->id())->pluck('hall_name', 'id'))
                    ->required()
                    ->searchable(),

                TextInput::make('sale_price')
                    ->label('سعر العرض')
                    ->required()
                    ->numeric()
                    ->prefix('د.ل'),

                DateTimePicker::make('start_date')
                    ->label('تاريخ بداية العرض')
                    ->required(),

                DateTimePicker::make('end_date')
                    ->label('تاريخ نهاية العرض')
                    ->required(),

                TextInput::make('discount_percentage')
                    ->label('نسبة الخصم')
                    ->numeric()
                    ->suffix('%')
                    ->maxValue(100)
                    ->minValue(0),

                Textarea::make('description')
                    ->label('وصف العرض')
                    ->rows(3),

                Toggle::make('status')
                    ->label('حالة العرض')
                    ->default(true)
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('weddingHall.hall_name')
                    ->label('القاعة')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('sale_price')
                    ->label('سعر العرض')
                    ->money('lyd')
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('تاريخ البداية')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('تاريخ النهاية')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('discount_percentage')
                    ->label('نسبة الخصم')
                    ->suffix('%')
                    ->sortable(),

                IconColumn::make('status')
                    ->label('الحالة')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOfferSales::route('/'),
            'create' => Pages\CreateOfferSale::route('/create'),
            'edit' => Pages\EditOfferSale::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->whereHas('weddingHall', function ($query) {
                $query->where('user_id', auth()->id());
            });
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'weddingHall.hall_name',
            'description',
            'discount_percentage',
        ];
    }
}
