<?php

namespace App\Filament\Dashboard\Resources\Customers;

use App\Filament\Dashboard\Resources\Customers\Pages\ListCustomers;
use App\Filament\Dashboard\Resources\Customers\Schemas\CustomerForm;
use App\Filament\Dashboard\Resources\Customers\Tables\CustomersTable;
use App\Models\Customer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserCircle;

    public static function getModelLabel(): string
    {
        return __('customers.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('customers.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.Admin Management');
    }

    public static function form(Schema $schema): Schema
    {
        return CustomerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomersTable::configure($table);
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
            'index' => ListCustomers::route('/'),
        ];
    }
}
