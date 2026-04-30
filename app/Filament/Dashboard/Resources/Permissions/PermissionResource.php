<?php

namespace App\Filament\Dashboard\Resources\Permissions;

use App\Filament\Dashboard\Resources\Permissions\Pages\ListPermissions;
use App\Filament\Dashboard\Resources\Permissions\Schemas\PermissionForm;
use App\Filament\Dashboard\Resources\Permissions\Tables\PermissionsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Spatie\Permission\Models\Permission;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::LockClosed;

    public static function getModelLabel(): string
    {
        return __('permissions.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('permissions.plural_label');
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
        return PermissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PermissionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPermissions::route('/'),
        ];
    }
}
