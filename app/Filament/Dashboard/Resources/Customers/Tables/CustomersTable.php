<?php

namespace App\Filament\Dashboard\Resources\Customers\Tables;

use App\Filament\Dashboard\Resources\Customers\Actions\AssignAdminAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('customers.columns.name'))
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->label(__('customers.columns.phone_number'))
                    ->searchable(),
                TextColumn::make('address')
                    ->label(__('customers.columns.address')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->color('info')
                    ->label(__('customers.actions.edit'))
                    ->successNotificationTitle(__('customers.actions.edit_success', ['label' => __('customers.label')])),
                DeleteAction::make()
                    ->label(__('customers.actions.delete'))
                    ->successNotificationTitle(__('customers.actions.delete_success', ['label' => __('customers.label')])),
                AssignAdminAction::make()
                    ->color('success'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('customers.actions.delete'))
                        ->successNotificationTitle(__('customers.actions.delete_multiple_success', ['label' => __('customers.plural_label')])),
                ]),
            ]);
    }
}
