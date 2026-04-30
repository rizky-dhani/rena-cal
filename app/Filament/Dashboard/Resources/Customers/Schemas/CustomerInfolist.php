<?php

namespace App\Filament\Dashboard\Resources\Customers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('customers.sections.details'))
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('customers.form.name.label')),
                        TextEntry::make('phone_number')
                            ->label(__('customers.form.phone_number.label')),
                        TextEntry::make('category.name')
                            ->label(__('customers.form.categories.label')),
                        TextEntry::make('type')
                            ->label(__('customers.form.type.label')),
                        TextEntry::make('province.name')
                            ->label(__('customers.form.province.label')),
                        TextEntry::make('address')
                            ->label(__('customers.form.address.label'))
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
