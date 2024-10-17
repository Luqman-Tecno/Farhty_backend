<?php

namespace App\Filament\HallAdminPanel\Resources\ServicesResource\Pages;

use App\Filament\HallAdminPanel\Resources\ServicesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditServices extends EditRecord
{
    protected static string $resource = ServicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
