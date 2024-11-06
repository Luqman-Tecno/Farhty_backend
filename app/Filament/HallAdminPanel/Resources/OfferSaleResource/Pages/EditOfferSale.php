<?php

namespace App\Filament\HallAdminPanel\Resources\OfferSaleResource\Pages;

use App\Filament\HallAdminPanel\Resources\OfferSaleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOfferSale extends EditRecord
{
    protected static string $resource = OfferSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
