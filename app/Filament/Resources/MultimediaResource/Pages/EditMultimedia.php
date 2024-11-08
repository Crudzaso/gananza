<?php

namespace App\Filament\Resources\MultimediaResource\Pages;

use App\Filament\Resources\MultimediaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMultimedia extends EditRecord
{
    protected static string $resource = MultimediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
