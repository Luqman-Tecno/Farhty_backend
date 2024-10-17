<?php

namespace App\Filament\Resources;

use App\Enum\BookingShiftEnum;
use App\Enum\UserTypeEnum;
use App\Filament\Resources\WeddingHallResource\Pages;
use App\Filament\Resources\WeddingHallResource\RelationManagers;
use App\Models\City;
use App\Models\User;
use App\Models\WeddingHall;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WeddingHallResource extends Resource
{
    protected static ?string $model = WeddingHall::class;

    protected static ?string $navigationLabel = 'ادارة قاعات الافراح';
    protected static ?string $navigationGroup = 'العمليات';
    protected static ?string $modelLabel = 'قاعة';
    protected static ?string $pluralModelLabel = 'قاعات';
    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('معلومات القاعة الأساسية')
                        ->schema([
                            Forms\Components\Grid::make([])->schema([
                                Forms\Components\Select::make('user_id')
                                    ->label('المالك')
                                    ->options(User::where('type', UserTypeEnum::WEDDING_ADMIN->value)->pluck('name', 'id'))
                                    ->required(),
                                Forms\Components\TextInput::make('hall_name')
                                    ->label('اسم القاعة')
                                    ->required(),
                                Forms\Components\TextInput::make('capacity')
                                    ->label('السعة')
                                    ->required()
                                    ->numeric(),
                                Forms\Components\Select::make('city_id')
                                    ->label('المدينة')
                                    ->options(City::pluck('name_ar', 'id'))
                                    ->required(),
                                Forms\Components\TextInput::make('region')
                                    ->label('المنطقة')
                                    ->required(),
                            ])->columns('2'),
                        ]),
                    Forms\Components\Wizard\Step::make('الأسعار والمميزات')
                        ->schema([
                            Forms\Components\Section::make('اسعار الفترات')
                                ->statePath('shift_prices')
                                ->schema([
                                    Forms\Components\TextInput::make(BookingShiftEnum::DAY->value)->label('صباح')->numeric()
                                        ->prefix('د.ل')
                                        ->inputMode('decimal')
                                        ->step(0.01),
                                    Forms\Components\TextInput::make(BookingShiftEnum::NIGHT->value)->label('مساء')->numeric()
                                        ->prefix('د.ل')
                                        ->inputMode('decimal')
                                        ->step(0.01),
                                    Forms\Components\TextInput::make(BookingShiftEnum::FULL_DAY->value)->label('اليوم كله')->numeric()
                                        ->prefix('د.ل')
                                        ->inputMode('decimal')
                                        ->step(0.01),
                                ])->columns('3'),
                            Forms\Components\Grid::make()->schema([
                                Forms\Components\TextInput::make('deposit_price')
                                    ->label('قيمة العربون')
                                    ->required()
                                    ->numeric()
                                    ->prefix('د.ل')
                                    ->inputMode('decimal')
                                    ->step(0.01),
                                Forms\Components\TextInput::make('price_per_child')
                                    ->label('تكلفة الطفل الواحد')
                                    ->required()
                                    ->numeric()
                                    ->prefix('د.ل')
                                    ->inputMode('decimal')
                                    ->step(0.01),
                                Forms\Components\Textarea::make('amenities')
                                    ->label('المرافق والخدمات')
                                    ->nullable(),])->columns(2),
                        ]),
                    Forms\Components\Wizard\Step::make('الموقع')
                        ->schema([
                            Forms\Components\Fieldset::make('اختار الموقع')->schema([
                                Forms\Components\View::make('components.map')
                                    ->columnSpan('full'),
                                Forms\Components\Hidden::make('latitude'),
                                Forms\Components\Hidden::make('longitude'),
                            ]),
                        ]), Forms\Components\Wizard\Step::make('الصور')
                        ->schema([
                            Forms\Components\FileUpload::make('images')->disk('public')
                                ->directory('hall_images')
                                ->multiple()
                        ]),
                ])
                    ->columnSpan('full')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\Layout\Panel::make([
                        Tables\Columns\ImageColumn::make('images')
                            ->label('صور القاعة')
                            ->circular()
                            ->stacked()
                            ->limit(3),
                        Tables\Columns\TextColumn::make('hall_name')
                            ->label('اسم القاعة')
                            ->searchable()
                            ->sortable()
                            ->weight('bold')
                            ->size('lg'),
                        Tables\Columns\TextColumn::make('city.name_ar')
                            ->label('المدينة')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('region')
                            ->label('المنطقة')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('shift_prices.'.BookingShiftEnum::DAY->value)
                            ->label('سعر الفترة الصباحية')
                            ->money('sar')
                            ,
                        Tables\Columns\TextColumn::make('shift_prices.'.BookingShiftEnum::NIGHT->value)
                            ->label('سعر الفترة المسائية')
                            ->money('sar')
                            ,
                    ])->collapsible(),
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWeddingHalls::route('/'),
            'create' => Pages\CreateWeddingHall::route('/create'),
            'edit' => Pages\EditWeddingHall::route('/{record}/edit'),
            'view' => Pages\ViewWeddingHalls::route('/{record}')
        ];
    }


    public static function getGloballySearchableAttributes(): array
    {
        return ['hall_name'];
    }
}
