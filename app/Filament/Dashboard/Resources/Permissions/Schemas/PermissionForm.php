<?php

namespace App\Filament\Dashboard\Resources\Permissions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('permissions.form.name.label'))
                    ->required(),
                Select::make('guard_name')
                    ->label(__('permissions.form.guard_name.label'))
                    ->options([
                        'web' => 'web',
                    ])
                    ->default('web')
                    ->required(),
            ]);
    }
}
