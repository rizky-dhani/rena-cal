<?php

namespace App\Filament\Dashboard\Resources\Roles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('roles.form.name.label'))
                    ->required(),
                Select::make('guard_name')
                    ->label(__('roles.form.guard_name.label'))
                    ->options([
                        'web' => 'web',
                    ])
                    ->default('web')
                    ->required(),
                Select::make('permissions')
                    ->multiple()
                    ->relationship('permissions', 'name')
                    ->preload()
                    ->label(__('roles.formpermissions.label'))
                    ->helperText(__('roles.formpermissions.helper_text'))
                    ->columnSpanFull(),
            ]);
    }
}
