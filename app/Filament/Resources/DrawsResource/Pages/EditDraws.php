<?php

namespace App\Filament\Resources\DrawsResource\Pages;

use App\Filament\Resources\DrawsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDraws extends EditRecord
{
    protected static string $resource = DrawsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
