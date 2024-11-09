<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserPermissionResource\Pages;
use App\Models\User;
use App\Models\UserPermissionAssignment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;

class UserPermissionResource extends Resource
{
    protected static ?string $model = UserPermissionAssignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationGroup = 'User Administration';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('model_id')
                    ->label('Usuario')
                    ->options(User::all()->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('permission_id')
                    ->label('Permiso')
                    ->options(Permission::where('guard_name', 'web')
                        ->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\Hidden::make('model_type')
                    ->default(User::class)
                    ->dehydrated(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('permission.name')
                    ->label('Permiso')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('permission.guard_name')
                    ->label('Guard')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->label('Usuario')
                    ->searchable()
                    ->preload(),
                
                Tables\Filters\SelectFilter::make('permission')
                    ->relationship('permission', 'name')
                    ->label('Permiso')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->label('Revocar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Revocar Seleccionados'),
                ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserPermissions::route('/'),
            'create' => Pages\CreateUserPermission::route('/create'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('model_type', User::class);
    }

    public static function getModelLabel(): string
    {
        return 'Permiso de Usuario';
    }

    public static function getLabel(): string
    {
        return 'Permission assignment';
    }

    public static function getPluralLabel(): string
    {
        return 'Permission assignments';
    }
}