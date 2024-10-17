<?php

namespace App\Filament\Resources\WeddingHallResource\Pages;

use App\Filament\Resources\WeddingHallResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateWeddingHall extends CreateRecord
{
    protected static string $resource = WeddingHallResource::class;


    public $latitude;
    public $longitude;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['latitude'] = $this->latitude;
        $data['longitude'] = $this->longitude;
        return $data;
    }
}
