<?php

namespace App\Filament\Dashboard\Resources\Types\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('brand.name')
                    ->label(__('types.columns.brand'))
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('types.columns.name'))
                    ->searchable(),
                TextColumn::make('slug')
                    ->label(__('types.columns.slug'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->color('info')
                    ->label(__('types.actions.edit'))
                    ->successNotificationTitle(__('types.actions.edit_success', ['label' => __('types.label')])),
                DeleteAction::make()
                    ->label(__('types.actions.delete'))
                    ->successNotificationTitle(__('types.actions.delete_success', ['label' => __('types.label')])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('types.actions.delete'))
                        ->successNotificationTitle(__('types.actions.delete_multiple_success', ['label' => __('types.plural_label')])),
                ]),
            ]);
    }
}
