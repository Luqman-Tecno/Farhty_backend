<?php

namespace App\Filament\Resources\WeddingHallResource\Pages;

use App\Filament\Resources\WeddingHallResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWeddingHall extends EditRecord
{
    protected static string $resource = WeddingHallResource::class;

    public $latitude;
    public $longitude;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['latitude'] = $this->latitude;
        $data['longitude'] = $this->longitude;
        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->latitude = $data['latitude'];
        $this->longitude = $data['longitude'];
        return $data;
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
