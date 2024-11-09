<?php

namespace App\Filament\Resources\MultimediaResource\Pages;

use App\Filament\Resources\MultimediaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMultimedia extends ListRecords
{
    protected static string $resource = MultimediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
