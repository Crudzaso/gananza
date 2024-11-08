<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketsResource\Pages;
use App\Filament\Resources\TicketsResource\RelationManagers;
use Modules\Ticket\Models\Ticket; // Asegúrate de usar el modelo correcto
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\DateColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;

class TicketsResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    // Configuración del formulario
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('raffle_id')
                    ->label('Raffle')
                    ->relationship('raffle', 'description') // Cambié 'name' por 'description', ajusta según tu campo
                    ->required(),

                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name') // Aquí sí parece correcto
                    ->required(),

                TextInput::make('ticket_number')
                    ->label('Ticket Number')
                    ->required()
                    ->maxLength(10),

                DateTimePicker::make('purchase_date')
                    ->label('Purchase Date')
                    ->nullable(),

                DateTimePicker::make('end_date')
                    ->label('End Date')
                    ->nullable(),

                TextInput::make('verification_code')
                    ->label('Verification Code')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    // Configuración de la tabla
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('raffle.description') // Cambié 'name' por 'description', ajusta según tu campo
                    ->label('Raffle')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('ticket_number')
                    ->label('Ticket Number')
                    ->sortable(),

                // Usamos TextColumn y aplicamos el formato de fecha
                TextColumn::make('purchase_date')
                    ->label('Purchase Date')
                    ->sortable()
                    ->date('Y-m-d H:i:s'), // Ajusta el formato de la fecha

                TextColumn::make('end_date')
                    ->label('End Date')
                    ->sortable()
                    ->date('Y-m-d H:i:s'), // Ajusta el formato de la fecha

                BadgeColumn::make('verification_code')
                    ->label('Verification Code')
                    ->sortable()
                    ->color('success'),
            ])
            ->filters([
                // Puedes agregar filtros aquí si es necesario
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

    public static function getRelations(): array
    {
        return [
            // Aquí puedes agregar gestores de relaciones si lo deseas
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTickets::route('/create'),
            'edit' => Pages\EditTickets::route('/{record}/edit'),
        ];
    }
}
