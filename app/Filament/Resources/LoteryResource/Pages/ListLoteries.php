<?php

namespace App\Filament\Resources\LoteryResource\Pages;

use App\Filament\Resources\LoteryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLoteries extends ListRecords
{
    protected static string $resource = LoteryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
