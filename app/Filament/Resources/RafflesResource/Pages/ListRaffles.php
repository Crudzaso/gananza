<?php

namespace App\Filament\Resources\RafflesResource\Pages;

use App\Filament\Resources\RafflesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRaffles extends ListRecords
{
    protected static string $resource = RafflesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
