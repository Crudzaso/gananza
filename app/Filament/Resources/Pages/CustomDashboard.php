<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard;
use Filament\Actions\Action;

class CustomDashboard extends Dashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('dashboard')
                ->label('Ir al Dashboard')
                ->url('/dashboard')  // O usa route('dashboard') si tienes la ruta nombrada
                ->color('gray')
                ->icon('heroicon-o-home'),
        ];
    }

    public function getTitle(): string
    {
        return 'Dashboard';
    }
}