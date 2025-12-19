<?php

namespace App\Filament\Dashboard\Resources\CustomerCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CustomerCategoriesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('customer_categories.form.name.label'))
                    ->columnSpanFull()
                    ->required(),
            ]);
    }
}
