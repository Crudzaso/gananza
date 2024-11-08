<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RewardsResource\Pages;
use App\Models\Reward; // Asegúrate de usar el modelo adecuado
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Modules\Reward\Models\Reward as ModelsReward;

class RewardsResource extends Resource
{
    protected static ?string $model = ModelsReward::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    /**
     * Definir el formulario para crear o editar recompensas.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Usuario')
                    ->options(\App\Models\User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                TextInput::make('points')
                    ->label('Puntos Acumulados')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                TextInput::make('redeemed_points')
                    ->label('Puntos Canjeados')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->required(),
            ]);
    }

    /**
     * Definir la tabla para la visualización de recompensas.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->sortable(),
                Tables\Columns\TextColumn::make('points')
                    ->label('Puntos Acumulados')
                    ->sortable(),
                Tables\Columns\TextColumn::make('redeemed_points')
                    ->label('Puntos Canjeados')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado en')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                // Puedes agregar filtros si es necesario
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Definir las páginas del recurso.
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRewards::route('/'),
            'create' => Pages\CreateRewards::route('/create'),
            'edit' => Pages\EditRewards::route('/{record}/edit'),
        ];
    }
}
