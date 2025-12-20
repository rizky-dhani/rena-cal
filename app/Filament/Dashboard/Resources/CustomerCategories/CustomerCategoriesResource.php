<?php

namespace App\Filament\Dashboard\Resources\CustomerCategories;

use App\Models\CustomerCategory;
use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Dashboard\Resources\CustomerCategories\Pages\CreateCustomerCategory;
use App\Filament\Dashboard\Resources\CustomerCategories\Pages\EditCustomerCategory;
use App\Filament\Dashboard\Resources\CustomerCategories\Pages\ListCustomerCategories;
use App\Filament\Dashboard\Resources\CustomerCategories\Pages\ViewCustomerCategory;
use App\Filament\Dashboard\Resources\CustomerCategories\Schemas\CustomerCategoryForm;
use App\Filament\Dashboard\Resources\CustomerCategories\Tables\CustomerCategoriesTable;

class CustomerCategoriesResource extends Resource
{
    protected static ?string $model = CustomerCategory::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationLabel(): string
    {
        return __('customer_categories.navigation_label');
    }

    public static function getNavigationParentItem(): ?string
    {
        return __('customers.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('customer_categories.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('customer_categories.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.User Management');
    }

    public static function form(Schema $schema): Schema
    {
        return CustomerCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomerCategoriesTable::configure($table);
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
            'index' => ListCustomerCategories::route('/'),
        ];
    }
}
