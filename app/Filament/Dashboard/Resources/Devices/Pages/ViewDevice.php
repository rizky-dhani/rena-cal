<?php

namespace App\Filament\Dashboard\Resources\Devices\Pages;

use App\Filament\Dashboard\Resources\Devices\DeviceResource;
use App\Filament\Dashboard\Resources\Devices\Schemas\DeviceInfolist;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewDevice extends ViewRecord
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->color('info')
                ->visible(fn ($record) => auth()->id() === $record->pic_id || auth()->user()->hasAnyRole(['Admin', 'Super Admin'])),
            Actions\Action::make('send_renewal_view')
                ->label(__('notifications.calibration_renewal.send_renewal_manual'))
                ->icon('heroicon-o-envelope')
                ->color('warning')
                ->visible(fn ($record) => 
                    auth()->user()->hasAnyRole(['Super Admin', 'Admin']) &&
                    $record->next_calibration_date &&
                    \Carbon\Carbon::parse($record->next_calibration_date)->isFuture()
                )
                ->action(function ($record) {
                    $admins = \App\Models\User::role('Hospital Admin')
                        ->where('customer_id', $record->customer_id)
                        ->get();

                    if ($admins->isNotEmpty()) {
                        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\CalibrationRenewalNotification(collect([$record])));
                        
                        \Filament\Notifications\Notification::make()
                            ->title(__('notifications.calibration_renewal.send_renewal_manual_success'))
                            ->success()
                            ->send();
                    } else {
                        \Filament\Notifications\Notification::make()
                            ->title('No Hospital Admins found for this customer.')
                            ->danger()
                            ->send();
                    }
                }),
            Actions\DeleteAction::make()
                ->color('danger')
                ->visible(fn ($record) => auth()->id() === $record->pic_id || auth()->user()->hasAnyRole(['Admin', 'Super Admin'])),
            Actions\Action::make('public_detail')
                ->label(__('devices.actions.public_detail'))
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->openUrlInNewTab()
                ->url(fn ($record) => route('devices.publicDetail', $record->deviceId)),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return DeviceInfolist::configure($schema);
    }
}
