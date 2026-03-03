<?php

namespace App\Filament\Dashboard\Resources\Brands;

use App\Filament\Dashboard\Resources\Brands\Pages\ListBrands;
use App\Filament\Dashboard\Resources\Brands\Schemas\BrandForm;
use App\Filament\Dashboard\Resources\Brands\Tables\BrandsTable;
use App\Models\Brand;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getModelLabel(): string
    {
        return __('brands.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('brands.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('brands.navigation_label');
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
        return BrandForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BrandsTable::configure($table);
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
            'index' => ListBrands::route('/'),
        ];
    }
}
