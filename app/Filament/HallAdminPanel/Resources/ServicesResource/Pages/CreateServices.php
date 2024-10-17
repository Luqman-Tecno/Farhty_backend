<?php

namespace App\Filament\HallAdminPanel\Resources\ServicesResource\Pages;

use App\Filament\HallAdminPanel\Resources\ServicesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateServices extends CreateRecord
{
    protected static string $resource = ServicesResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
