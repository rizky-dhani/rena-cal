<?php

namespace App\Filament\Dashboard\Resources\CustomerCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomerCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('customer_categories.columns.name.label'))
                    ->searchable(),
                TextColumn::make('slug')
                    ->label(__('customer_categories.columns.slug.label'))
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
                    ->successNotificationTitle(__('customer_categories.actions.delete_success', ['label' => __('customer_categories.label')])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('customer_categories.actions.delete'))
                        ->successNotificationTitle(__('customer_categories.actions.delete_multiple_success', ['label' => __('customer_categories.plural_label')])),
                ]),
            ]);
    }
}
