<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoteryResource\Pages;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Lotery\Models\Lotery;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Tables\Columns\TextColumn;

class LoteryResource extends Resource
{
    protected static ?string $model = Lotery::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Lottery Name')
                    ->required()
                    ->maxLength(255),

                TextArea::make('description')
                    ->label('Description')
                    ->nullable()
                    ->maxLength(500),

                TextInput::make('image_url') // Usamos TextInput para la URL
                    ->label('Image URL')
                    ->nullable()
                    ->url() // Esto asegura que solo se ingrese una URL válida
                    ->maxLength(1024),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Lottery Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('image_url')
                    ->label('Image URL') 
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
            'index' => Pages\ListLoteries::route('/'),
            'create' => Pages\CreateLotery::route('/create'),
            'edit' => Pages\EditLotery::route('/{record}/edit'),
        ];
    }
}
