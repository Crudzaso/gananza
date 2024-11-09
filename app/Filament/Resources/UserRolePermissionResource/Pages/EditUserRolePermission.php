<?php

namespace App\Filament\Resources\UserRolePermissionResource\Pages;

use App\Filament\Resources\UserRolePermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserRolePermission extends EditRecord
{
    protected static string $resource = UserRolePermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
