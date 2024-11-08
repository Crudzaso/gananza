<?php

namespace App\Filament\Resources\DrawsResource\Pages;

use App\Filament\Resources\DrawsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDraws extends ListRecords
{
    protected static string $resource = DrawsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
