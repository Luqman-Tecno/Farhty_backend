<?php

namespace App\Filament\HallAdminPanel\Pages;

use App\Enum\BookingShiftEnum;
use App\Models\WeddingHall;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\View;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class ManageWeddingHall extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static string $view = 'filament.hall-admin-panel.pages.manage-wedding-hall';
    protected static ?string $navigationLabel = 'ادارة بيانات القاعة';

    protected static ?string $modelLabel = 'قاعة';
    protected static ?string $pluralModelLabel = 'قاعات';
    protected ?string $heading = "بيانات القاعة";
    public ?array $data = [];
    protected static ?string $navigationGroup = 'الصالة';
    public $latitude;
    public $longitude;
    public WeddingHall $weddingHall;

    public function mount(): void
    {
        $this->weddingHall = WeddingHall::where('user_id', Auth::id())->firstOrFail();
        $this->form->fill($this->weddingHall->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('المعلومات الأساسية')
                    ->schema([
                        TextInput::make('hall_name')
                            ->label('اسم القاعة')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('capacity')
                            ->label('السعة')
                            ->required()
                            ->numeric()
                            ->minValue(1),
                        Textarea::make('amenities')
                            ->label('المرافق')
                            ->required()
                            ->maxLength(65535),
                    ])->columns(2),

                Section::make('الأسعار')
                    ->schema([
                        Grid::make(2)->schema([
                            Section::make('اسعار الفترات')
                                ->statePath('shift_prices')
                                ->schema([
                                    TextInput::make(BookingShiftEnum::DAY->value)->label('صباح')->numeric()
                                        ->prefix('د.ل')
                                        ->inputMode('decimal')
                                        ->step(0.01),
                                    TextInput::make(BookingShiftEnum::NIGHT->value)->label('مساء')->numeric()
                                        ->prefix('د.ل')
                                        ->inputMode('decimal')
                                        ->step(0.01),
                                    TextInput::make(BookingShiftEnum::FULL_DAY->value)->label('اليوم كله')->numeric()
                                        ->prefix('د.ل')
                                        ->inputMode('decimal')
                                        ->step(0.01),
                                ])->columns('3'),
                            TextInput::make('deposit_price')
                                ->label('مبلغ العربون')
                                ->required()
                                ->numeric()
                                ->prefix('د.ل')
                                ->inputMode('decimal')
                                ->step(0.01),
                            TextInput::make('price_per_child')
                                ->label('السعر لكل طفل')
                                ->required()
                                ->numeric()
                                ->prefix('د.ل')
                                ->inputMode('decimal')
                                ->step(0.01),
                        ]),
                    ]),

                Section::make('الصور')
                    ->schema([
                        FileUpload::make('images')
                            ->label('صور القاعة')
                            ->image()
                            ->multiple()
                            ->disk('public')
                            ->directory('hall_images')
                            ->columnSpanFull(),
                    ]),
                Section::make(' الموقع')
                    ->schema([
                        View::make('components.map')->columnSpan('full'),
                        Hidden::make('latitude'),
                        Hidden::make('longitude'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $data['latitude'] = $this->latitude;
        $data['longitude'] = $this->longitude;

        $this->weddingHall->update($data);

        Notification::make()
            ->title('تم تحديث معلومات قاعة الافراح بنجاح')
            ->success()
            ->send();
    }
}
