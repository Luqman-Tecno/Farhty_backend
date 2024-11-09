<?php

namespace App\Filament\HallAdminPanel\Resources\OfferSaleResource\Pages;

use App\Filament\HallAdminPanel\Resources\OfferSaleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOfferSale extends CreateRecord
{
    protected static string $resource = OfferSaleResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['wedding_hall_id'] = auth()->user()->weddingHall->id;
        return $data;
    }
    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
