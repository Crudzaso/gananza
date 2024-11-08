<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MultimediaResource\Pages;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextArea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Multimedia\Models\Multimedia;
use Filament\Tables\Columns\TextColumn;

class MultimediaResource extends Resource
{
    protected static ?string $model = Multimedia::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('file_name')
                    ->label('File Name')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('file_path')
                    ->label('File')
                    ->required()
                    ->disk('public') // Asegúrate de tener configurado el disco en `config/filesystems.php`
                    ->directory('multimedia') // Opcional: define una carpeta dentro de `storage/app/public`
                    ->maxSize(10240), // Limitar tamaño del archivo

                Select::make('file_type')
                    ->label('File Type')
                    ->options([
                        'VIDEO' => 'Video',
                        'PDF' => 'PDF',
                        'IMAGEN' => 'Image',
                    ])
                    ->nullable(),

                TextInput::make('mime_type')
                    ->label('Mime Type')
                    ->nullable(),

                TextInput::make('size')
                    ->label('File Size')
                    ->nullable()
                    ->numeric(),
                
                TextInput::make('model_id')
                    ->label('Model ID')
                    ->nullable()
                    ->numeric(),

                Select::make('model_type')
                    ->label('Model Type')
                    ->options([
                        'raffles' => 'Raffles',
                        'tickets' => 'Tickets',
                    ])
                    ->nullable(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('file_name')
                    ->label('File Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('file_type')
                    ->label('File Type')
                    ->sortable(),

                TextColumn::make('model_type')
                    ->label('Model Type')
                    ->sortable(),
                
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                // Agregar filtros si es necesario
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
            // Relacionar otras entidades si es necesario
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMultimedia::route('/'),
            'create' => Pages\CreateMultimedia::route('/create'),
            'edit' => Pages\EditMultimedia::route('/{record}/edit'),
        ];
    }
}
