<?php

namespace App\Filament\Resources\UserRolePermissionResource\Pages;

use App\Filament\Resources\UserRolePermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserRolePermissions extends ListRecords
{
    protected static string $resource = UserRolePermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
