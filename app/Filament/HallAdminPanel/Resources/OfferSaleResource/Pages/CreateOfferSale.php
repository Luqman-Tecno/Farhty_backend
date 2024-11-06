<?php

namespace App\Filament\HallAdminPanel\Resources\OfferSaleResource\Pages;

use App\Filament\HallAdminPanel\Resources\OfferSaleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOfferSale extends CreateRecord
{
    protected static string $resource = OfferSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
