<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RafflesResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\DateTimePicker;
use Modules\Raffle\Models\Raffle;
use App\Models\User; // Asegúrate de importar el modelo User
use Modules\Lotery\Models\Lotery;
use Modules\Lottery\Models\Lottery; // Asegúrate de importar el modelo Lottery

class RafflesResource extends Resource
{
    protected static ?string $model = Raffle::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Models';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('name')
                    ->label('Rifa')
                    ->required(),

                Select::make('organizer_id')
                    ->label('Organizador')
                    ->options(User::all()->pluck('name', 'id'))
                    ->required(),

                Select::make('lottery_id')
                    ->label('Lotería')
                    ->options(Lotery::all()->pluck('name', 'id'))
                    ->required(),

                TextInput::make('ticket_price')
                    ->label('Precio del Boleto')
                    ->numeric()
                    ->required(),

                TextInput::make('total_tickets')
                    ->label('Total de Boletos')
                    ->numeric()
                    ->required(),

                TextInput::make('tickets_sold')
                    ->label('Boletos Vendidos')
                    ->numeric()
                    ->default(0)
                    ->required(),

                TextArea::make('description')
                    ->label('Descripción')
                    ->nullable(),

                DateTimePicker::make('start_date')
                    ->label('Fecha de Inicio')
                    ->required()
                    ->default(now()),

                DateTimePicker::make('end_date')
                    ->label('Fecha de Finalización')
                    ->required()
                    ->default(now()->addDays(7)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nombre')->sortable(),
                Tables\Columns\TextColumn::make('organizer.name')->label('Organizador')->sortable(),
                Tables\Columns\TextColumn::make('lottery.name')->label('Lotería')->sortable(),
                Tables\Columns\TextColumn::make('ticket_price')->label('Precio del Boleto')->sortable(),
                Tables\Columns\TextColumn::make('start_date')->label('Fecha de Inicio')->sortable()->dateTime(),
                Tables\Columns\TextColumn::make('end_date')->label('Fecha de Finalización')->sortable()->dateTime(),
                Tables\Columns\TextColumn::make('created_at')->label('Creado en')->sortable()->dateTime(),
            ])
            ->filters([
                // Filtros si es necesario
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRaffles::route('/'),
            'create' => Pages\CreateRaffles::route('/create'),
            'edit' => Pages\EditRaffles::route('/{record}/edit'),
        ];
    }
}
