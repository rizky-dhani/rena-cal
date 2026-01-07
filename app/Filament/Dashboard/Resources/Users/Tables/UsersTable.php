<?php

namespace App\Filament\Dashboard\Resources\Users\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                $query->where('id', '!=', auth()->user()->id)
                    ->whereDoesntHave('roles', function ($query) {
                        $query->where('name', 'Super Admin');
                    })
                    ->orderByDesc('created_at');
            })
            ->columns([
                TextColumn::make('name')
                    ->label(__('users.columns.name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('users.columns.email'))
                    ->searchable(),
                TextColumn::make('initial')
                    ->label(__('users.columns.initial'))
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label(__('users.columns.roles')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('reset_password')
                    ->label(__('users.actions.reset_password'))
                    ->icon(Heroicon::ArrowPathRoundedSquare)
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn () => auth()->user()->can('reset-password-users'))
                    ->action(function ($record) {
                        $record->update([
                            'password' => Hash::make('Calibration2025!'),
                        ]);
                    })
                    ->successNotificationTitle(__('users.actions.reset_password_success')),
                EditAction::make()
                    ->color('info')
                    ->label(__('users.actions.edit'))
                    ->successNotificationTitle(__('users.actions.edit_success', ['label' => __('users.label')])),
                DeleteAction::make()
                    ->label(__('users.actions.delete'))
                    ->successNotificationTitle(__('users.actions.delete_success', ['label' => __('users.label')])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('users.actions.delete'))
                        ->successNotificationTitle(__('users.actions.delete_multiple_success', ['label' => __('users.plural_label')])),
                ]),
            ]);
    }
}
