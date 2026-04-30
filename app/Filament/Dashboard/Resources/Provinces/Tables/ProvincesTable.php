<?php

namespace App\Filament\Dashboard\Resources\Provinces\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProvincesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label(__('provinces.columns.code.label')),
                TextColumn::make('name')
                    ->label(__('provinces.columns.name.label'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->color('info')
                    ->label(__('devices.actions.edit'))
                    ->successNotificationTitle(__('provinces.notifications.success', ['label' => __('provinces.label')])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('devices.actions.delete'))
                        ->successNotificationTitle(__('devices.actions.delete_multiple_success', ['label' => __('provinces.label')])),
                ]),
            ]);
    }
}
