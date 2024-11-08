<?php

namespace App\Filament\Resources\LoteryResource\Pages;

use App\Filament\Resources\LoteryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLotery extends EditRecord
{
    protected static string $resource = LoteryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
