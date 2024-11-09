<?php

namespace App\Filament\Resources\WeddingHallResource\Pages;

use App\Filament\Resources\WeddingHallResource;
use Filament\Actions;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewWeddingHalls extends ViewRecord
{
    protected static string $resource = WeddingHallResource::class;

    protected static string $view = 'filament.resources.wedding-halls.pages.list-wedding-halls';

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\EditAction::make(),
            \Filament\Actions\DeleteAction::make(),
        ];
    }

    /**
     * @return string
     */


}
