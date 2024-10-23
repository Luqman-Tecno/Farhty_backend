<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

class SearchFilters extends Component implements HasForms
{
    use InteractsWithForms;

    public $selectedCities = [];
    public $selectedDate;
    public $minPrice;
    public $maxPrice;

    // City toggles
    public $riyadh = false;
    public $jeddah = false;
    public $mecca = false;
    public $dammam = false;

    protected function getFormSchema(): array
    {
        return [
            Grid::make(3)
                ->schema([
                    Card::make()
                        ->schema([
                            Toggle::make('riyadh')
                                ->label('الرياض')
                                ->onIcon('heroicon-s-check')
                                ,
                            Toggle::make('jeddah')
                                ->label('جدة')
                                ->onIcon('heroicon-s-check')
                               ,
                            Toggle::make('mecca')
                                ->label('مكة')
                                ->onIcon('heroicon-s-check')
                               ,
                            Toggle::make('dammam')
                                ->label('الدمام')
                                ->onIcon('heroicon-s-check')

                        ])
                        ->columns(2)
                        ->heading('المدن'),

                    Card::make()
                        ->schema([
                            DatePicker::make('selectedDate')
                                ->label('تحديد الموعد')
                                ->placeholder('اختر التاريخ')
                                ->displayFormat('Y-m-d')
                                ->closeOnDateSelection(),
                        ])
                        ->heading('التاريخ'),

                    Card::make()
                        ->schema([
                            TextInput::make('minPrice')
                                ->label('السعر من')
                                ->type('number')
                                ->placeholder('0 ريال')
                                ->numeric()
                                ->minValue(0),
                            TextInput::make('maxPrice')
                                ->label('السعر إلى')
                                ->type('number')
                                ->placeholder('100,000 ريال')
                                ->numeric()
                                ->minValue(0),
                        ])
                        ->columns(2)
                        ->heading('نطاق السعر'),
                ]),
        ];
    }

    public function search()
    {
        // Collect selected cities
        $this->selectedCities = collect([
            'riyadh' => $this->riyadh,
            'jeddah' => $this->jeddah,
            'mecca' => $this->mecca,
            'dammam' => $this->dammam,
        ])->filter()->keys()->toArray();

        // Add your search logic here
        // You can access $this->selectedDate, $this->selectedCities, $this->minPrice, $this->maxPrice
    }

    public function render()
    {
        return view('livewire.search-filters');
    }
}
