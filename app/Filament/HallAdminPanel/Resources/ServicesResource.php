<?php

namespace App\Filament\HallAdminPanel\Resources;

use App\Filament\Resources\ServicesResource\Pages;
use App\Models\Services;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ServicesResource extends Resource
{
    protected static ?string $model = Services::class;

    protected static ?string $slug = 'services';

    protected static ?string $navigationLabel = "إدارة خدمات القاعة";
    protected static ?string $navigationGroup = 'الصالة';
    protected static ?string $modelLabel = 'خدمة';
    protected static ?string $pluralModelLabel = 'خدمات';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('اسم الخدمة')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('أدخل اسم الخدمة'),

                TextInput::make('price')->label('السعر')
                    ->required()
                    ->numeric()
                    ->prefix('د.ل')
                    ->inputMode('decimal')
                    ->step(0.01)
                    ->placeholder('أدخل السعر'),

                Hidden::make('wedding_hall_id')
                    ->default(function () {
                        return auth()->user()->weddingHall->id;
                    }),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('اسم الخدمة')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')->label('السعر بالدينار الليبي')
                    ->money('lyd')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])->query(
                Services::whereHas('weddingHall', function (Builder $query) {
                    $query->where('user_id', auth()->id());
                })
            );
    }



    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\HallAdminPanel\Resources\ServicesResource\Pages\ListServices::route('/'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
