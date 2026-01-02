<?php

namespace App\Filament\Dashboard\Resources\Customers\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

class UnassignAdminAction
{
    public static function make(): Action
    {
        return Action::make('unassign_admin')
            ->label(__('customers.actions.unassign_admin'))
            ->icon('heroicon-o-user-minus')
            ->color('danger')
            ->requiresConfirmation()
            ->form([
                Toggle::make('delete_user')
                    ->label(__('customers.form.delete_user.label'))
                    ->helperText(__('customers.form.delete_user.helper_text'))
                    ->default(false),
            ])
            ->action(function (Model $record, array $data) {
                if ($data['delete_user'] ?? false) {
                    $record->delete();
                    Notification::make()
                        ->title(__('customers.actions.delete_success', ['label' => __('users.label')]))
                        ->success()
                        ->send();
                } else {
                    $record->update(['customer_id' => null]);
                    Notification::make()
                        ->title(__('customers.actions.unassign_admin_success'))
                        ->success()
                        ->send();
                }
            });
    }
}
