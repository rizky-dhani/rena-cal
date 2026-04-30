<?php

namespace App\Filament\Dashboard\Resources\Roles;

use App\Filament\Dashboard\Resources\Roles\Pages\ListRoles;
use App\Filament\Dashboard\Resources\Roles\Pages\ViewRole;
use App\Filament\Dashboard\Resources\Roles\RelationManagers\PermissionsRelationManager;
use App\Filament\Dashboard\Resources\Roles\Schemas\RoleForm;
use App\Filament\Dashboard\Resources\Roles\Tables\RolesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    public static function getModelLabel(): string
    {
        return __('roles.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('roles.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.User Management');
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();

        return $user->hasRole('Super Admin');
    }

    public static function form(Schema $schema): Schema
    {
        return RoleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RolesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PermissionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'view' => ViewRole::route('/{record}'),
        ];
    }
}
