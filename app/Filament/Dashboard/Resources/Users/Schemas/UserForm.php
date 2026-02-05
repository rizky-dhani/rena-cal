<?php

namespace App\Filament\Dashboard\Resources\Users\Schemas;

use App\Models\Customer;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        $hospitalAdminRoleId = Role::where('name', 'Hospital Admin')->first()?->id;

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
                    ->live(), // Use live() for real-time updates
                Select::make('customer_id')
                    ->label(__('users.form.customer.label'))
                    ->options(Customer::pluck('name', 'id'))
                    ->searchable()
                    ->columnSpanFull()
                    ->visible(fn ($get) => in_array($hospitalAdminRoleId, $get('roles') ?? []))
                    ->required(fn ($get) => in_array($hospitalAdminRoleId, $get('roles') ?? [])),
            ]);
    }
}
