<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserRolePermissionResource\Pages;
use App\Models\User;
use App\Models\UserRoleAssignment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;

class UserRolePermissionResource extends Resource
{
    protected static ?string $model = UserRoleAssignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'User Administration';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('model_id')
                    ->label('Usuario')
                    ->options(User::all()->pluck('name', 'id'))
                    ->required()
                    ->searchable(),

                Select::make('role_id')
                    ->label('Rol')
                    ->options(Role::where('guard_name', 'web')->pluck('name', 'id'))
                    ->required()
                    ->searchable(),

                Forms\Components\Hidden::make('model_type')
                    ->default(User::class)
                    ->dehydrated(true) // Asegura que el campo se incluya en el envío
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
                
                Tables\Columns\TextColumn::make('role.name')
                    ->label('Rol')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUserRolePermissions::route('/'),
            'create' => Pages\CreateUserRolePermission::route('/create'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('model_type', User::class);
    }

    public static function getLabel(): string
    {
        return 'Role assignment';
    }

    public static function getPluralLabel(): string
    {
        return 'Role assignments';
    }
}