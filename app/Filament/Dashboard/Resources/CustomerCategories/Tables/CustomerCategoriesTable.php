<?php

namespace App\Filament\Dashboard\Resources\CustomerCategories\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class CustomerCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->color('info')
                    ->label(__('customer_categories.actions.edit'))
                    ->successNotificationTitle(__('customer_categories.actions.edit_success', ['label' => __('customer_categories.label')])),
                DeleteAction::make()
                    ->label(__('customer_categories.actions.delete'))
                    ->successNotificationTitle(__('customer_categories.actions.delete_success', ['label' => __('customer_categories.label')]))
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
