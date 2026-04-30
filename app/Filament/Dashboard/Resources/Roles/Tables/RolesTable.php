<?php

namespace App\Filament\Dashboard\Resources\Roles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RolesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('roles.columns.name'))
                    ->searchable(),
                TextColumn::make('guard_name')
                    ->label(__('roles.columns.guard_name'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label(__('roles.actions.view'))
                    ->color('dark'),
                EditAction::make()
                    ->color('info')
                    ->label(__('roles.actions.edit'))
                    ->successNotificationTitle(__('roles.actions.edit_success', ['label' => __('roles.label')])),
                DeleteAction::make()
                    ->label(__('roles.actions.delete'))
                    ->successNotificationTitle(__('roles.actions.delete_success', ['label' => __('roles.label')])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('roles.actions.delete'))
                        ->successNotificationTitle(__('roles.actions.delete_multiple_success', ['label' => __('roles.plural_label')])),
                ]),
            ]);
    }
}
