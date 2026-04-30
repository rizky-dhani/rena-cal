<?php

namespace App\Filament\Dashboard\Resources\DeviceNames;

use App\Filament\Dashboard\Resources\DeviceNames\Pages\ListDeviceNames;
use App\Filament\Dashboard\Resources\DeviceNames\Schemas\DeviceNameForm;
use App\Filament\Dashboard\Resources\DeviceNames\Tables\DeviceNamesTable;
use App\Models\DeviceName;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DeviceNameResource extends Resource
{
    protected static ?string $model = DeviceName::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getModelLabel(): string
    {
        return __('devicenames.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('devicenames.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('devicenames.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.Devices');
    }

    public static function getNavigationParentItem(): ?string
    {
        return __('devices.navigation_label');
    }

    public static function form(Schema $schema): Schema
    {
        return DeviceNameForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DeviceNamesTable::configure($table);
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
            'index' => ListDeviceNames::route('/'),
        ];
    }
}
