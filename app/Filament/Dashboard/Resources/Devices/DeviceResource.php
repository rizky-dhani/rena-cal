<?php

namespace App\Filament\Dashboard\Resources\Devices;

use App\Filament\Dashboard\Resources\Devices\Pages\ListDevices;
use App\Filament\Dashboard\Resources\Devices\Pages\ViewDevice;
use App\Filament\Dashboard\Resources\Devices\Schemas\DeviceForm;
use App\Filament\Dashboard\Resources\Devices\Schemas\DeviceInfolist;
use App\Filament\Dashboard\Resources\Devices\Tables\DevicesTable;
use App\Models\Device;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::QrCode;

    public static function getModelLabel(): string
    {
        return __('devices.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('devices.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('devices.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.Devices');
    }

    public static function getNavigationParentItem(): ?string
    {
        return null;
    }

    public static function form(Schema $schema): Schema
    {
        return DeviceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DeviceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DevicesTable::configure($table);
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
            'index' => ListDevices::route('/'),
            'view' => ViewDevice::route('/{record}'),
        ];
    }
}
