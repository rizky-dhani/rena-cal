<?php

namespace App\Filament\Dashboard\Resources\Users\Schemas;

use App\Models\Customer;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('users.form.name.label'))
                    ->required(),
                TextInput::make('email')
                    ->label(__('users.form.email.label'))
                    ->email()
                    ->required(),
                TextInput::make('initial')
                    ->label(__('users.form.initial.label'))
                    ->required(),
                Select::make('roles')
                    ->label(__('users.form.roles.label'))
                    ->multiple()
                    ->relationship('roles', 'name', fn ($query) => $query->where('id', '!=', 1))
                    ->preload()
                    ->reactive(), // Make the field reactive to changes
                Select::make('customer_id')
                    ->label(__('users.form.customer.label'))
                    ->options(Customer::pluck('name', 'id'))
                    ->searchable()
                    ->visible(fn ($get) => in_array('Hospital Admin', $get('roles') ?? []))
                    ->required(fn ($get) => in_array('Hospital Admin', $get('roles') ?? [])),
            ]);
    }
}
