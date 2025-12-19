<?php

namespace App\Filament\Dashboard\Resources\Customers\Schemas;

use App\Models\Province;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('customers.form.name.label'))
                    ->required(),
                TextInput::make('phone_number')
                    ->label(__('customers.form.phone_number.label'))
                    ->tel()
                    ->default(null),                
                Select::make('province_id')
                    ->label(__('customers.form.province.label'))
                    ->options(Province::all()->pluck('name', 'code')->toArray())
                    ->searchable()
                    ->preload(),
                Select::make('type')
                    ->label(__('customers.form.type.label'))
                    ->options([
                        ''
                    ]),
                Textarea::make('address')
                    ->label(__('customers.form.address.label'))
                    ->default(null)
                    ->columnSpanFull(),
            ])
            ->columns(3);
    }
}