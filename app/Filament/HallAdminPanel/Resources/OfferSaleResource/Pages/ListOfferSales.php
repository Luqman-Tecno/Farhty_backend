<?php

namespace App\Filament\HallAdminPanel\Resources\OfferSaleResource\Pages;

use App\Filament\HallAdminPanel\Resources\OfferSaleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOfferSales extends ListRecords
{
    protected static string $resource = OfferSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
