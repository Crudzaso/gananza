<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentsResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Modules\Payment\Models\Payment;
use App\Models\User; // Asegúrate de importar el modelo User
use Modules\Raffle\Models\Raffle; // Asegúrate de importar el modelo Raffle

class PaymentsResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Usuario')
                    ->options(User::all()->pluck('name', 'id'))
                    ->required(),

                Select::make('raffle_id')
                    ->label('Rifa')
                    ->options(Raffle::all()->mapWithKeys(function ($raffle) {
                        return [$raffle->id => "{$raffle->lottery_id} - {$raffle->description}"];
                    }))
                    ->required(),
                

                TextInput::make('amount')
                    ->label('Monto')
                    ->numeric()
                    ->required(),

                Select::make('payment_method')
                    ->label('Método de Pago')
                    ->options([
                        'NEQUI' => 'Nequi',
                        'EFECTIVO' => 'Efectivo',
                    ])
                    ->required(),

                DateTimePicker::make('payment_date')
                    ->label('Fecha de Pago')
                    ->required()
                    ->default(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Usuario')->sortable(),
                Tables\Columns\TextColumn::make('raffle.name')->label('Rifa')->sortable(),
                Tables\Columns\TextColumn::make('amount')->label('Monto')->sortable(),
                Tables\Columns\TextColumn::make('payment_method')->label('Método de Pago')->sortable(),
                Tables\Columns\TextColumn::make('payment_date')->label('Fecha de Pago')->sortable()->dateTime(),
                Tables\Columns\TextColumn::make('created_at')->label('Creado en')->sortable()->dateTime(),
            ])
            ->filters([
                // Aquí puedes añadir filtros si es necesario
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayments::route('/create'),
            'edit' => Pages\EditPayments::route('/{record}/edit'),
        ];
    }
}
