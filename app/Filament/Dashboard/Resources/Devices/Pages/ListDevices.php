<?php

namespace App\Filament\Dashboard\Resources\Devices\Pages;

use App\Filament\Dashboard\Resources\Devices\DeviceResource;
use App\Jobs\GenerateMultipleQRCodesJob;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;

class ListDevices extends ListRecords
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate_empty_qr')
                ->label(__('devices.actions.generate_empty_qr'))
                ->icon('heroicon-o-qr-code')
                ->color('success')
                ->form([
                    \Filament\Forms\Components\TextInput::make('number_of_qr')
                        ->label(__('devices.generate.qr_number'))
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(1000)
                        ->default(1)
                        ->required()
                        ->helperText(__('devices.generate.qr_number_helper')),
                ])
                ->action(function (array $data) {
                    $numberOfQr = (int) $data['number_of_qr'];

                    if ($numberOfQr <= 0) {
                        \Filament\Notifications\Notification::make()
                            ->title(__('devices.generate.invalid_number'))
                            ->body(__('devices.generate.invalid_number_body'))
                            ->danger()
                            ->send();

                        return;
                    }

                    // Create an array of devices with device IDs
                    $devices = [];
                    for ($i = 0; $i < $numberOfQr; $i++) {
                        $deviceId = (string) Str::orderedUuid();
                        $devices[] = [
                            'deviceId' => $deviceId,
                        ];
                    }

                    // Dispatch the job to generate QR codes in the background
                    GenerateMultipleQRCodesJob::dispatch($devices);

                    // Show success notification
                    \Filament\Notifications\Notification::make()
                        ->title(__('devices.generate.generate_success'))
                        ->success();
                }),
        ];
    }
}
