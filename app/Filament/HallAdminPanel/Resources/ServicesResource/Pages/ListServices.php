<?php

namespace App\Filament\HallAdminPanel\Resources\ServicesResource\Pages;

use App\Filament\HallAdminPanel\Resources\ServicesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListServices extends ListRecords
{
    protected static string $resource = ServicesResource::class;


    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
