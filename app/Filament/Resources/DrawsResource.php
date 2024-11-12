<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DrawsResource\Pages;
use App\Filament\Resources\DrawsResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Draws\Models\Draws as ModelsDraws;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Modules\Lottery\Models\Lottery;

class DrawsResource extends Resource
{
    protected static ?string $model = ModelsDraws::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Models';

    protected static ?int $navigationSort = 1;

    // Configuración del formulario
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('lottery_id')
                    ->label('Lottery')
                    ->options(function () {
                        return Lottery::all()->pluck('name', 'id');
                    })
                    ->required()
                    ->placeholder('Select Lottery'),

                DateTimePicker::make('draw_date')
                    ->label('Draw Date')
                    ->required()
                    ->displayFormat('Y-m-d H:i:s')
                    ->withoutSeconds(),

                TextArea::make('winning_numbers')
                    ->label('Winning Numbers')
                    ->nullable()
                    ->maxLength(255),
            ]);
    }

    // Configuración de la tabla
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lottery.name')  // Mostrar el nombre de la lotería asociada
                    ->label('Lottery')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('draw_date')
                    ->label('Draw Date')
                    ->sortable()
                    ->searchable()
                    ->dateTime(),

                TextColumn::make('winning_numbers')
                    ->label('Winning Numbers')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                // Puedes agregar filtros si es necesario
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Si deseas agregar más relaciones, agrégalas aquí
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDraws::route('/'),
            'create' => Pages\CreateDraws::route('/create'),
            'edit' => Pages\EditDraws::route('/{record}/edit'),
        ];
    }
}
