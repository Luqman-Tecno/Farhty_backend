<?php

namespace App\Filament\Resources\WeddingHallResource\Pages;

use App\Filament\Resources\WeddingHallResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWeddingHalls extends ListRecords
{
    protected static string $resource = WeddingHallResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
