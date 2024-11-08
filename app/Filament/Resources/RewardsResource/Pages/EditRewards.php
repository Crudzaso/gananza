<?php

namespace App\Filament\Resources\RewardsResource\Pages;

use App\Filament\Resources\RewardsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRewards extends EditRecord
{
    protected static string $resource = RewardsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
