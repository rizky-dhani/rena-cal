<?php

namespace App\Filament\Dashboard\Resources\Devices\Pages;

use App\Filament\Dashboard\Resources\Devices\DeviceResource;
use App\Jobs\GenerateMultipleQRCodesJob;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use pxlrbt\FilamentExcel\Actions\ExportAction;

class ListDevices extends ListRecords
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label(__('devices.export.label'))
                ->color('info')
                ->exports([
                    \App\Exports\DeviceExport::make()
                        ->modifyQueryUsing(function ($query, $data = []) {
                            $user = auth()->user();

                            if ($user && $user->hasRole('Hospital Admin') && $user->customer_id) {
                                $query->where('customer_id', $user->customer_id);
                            }

                            if (($data['export_type'] ?? null) === 'range') {
                                $dateField = $data['date_field'] ?? null;
                                $startDate = $data['start_date'] ?? null;
                                $endDate = $data['end_date'] ?? null;

                                if ($dateField && $startDate && $endDate) {
                                    return $query->whereBetween($dateField, [$startDate, $endDate]);
                                }
                            }

                            return $query;
                        }),
                ])
                ->form([
                    Radio::make('export_type')
                        ->label(__('devices.export.type.label'))
                        ->options([
                            'all' => __('devices.export.type.all'),
                            'range' => __('devices.export.type.range'),
                        ])
                        ->default('all')
                        ->reactive(),
                    Select::make('date_field')
                        ->label(__('devices.export.date_field.label'))
                        ->options([
                            'calibration_date' => __('devices.export.date_field.calibration_date'),
                            'next_calibration_date' => __('devices.export.date_field.next_calibration_date'),
                        ])
                        ->default('calibration_date')
                        ->visible(fn ($get) => $get('export_type') === 'range')
                        ->required(fn ($get) => $get('export_type') === 'range'),
                    DatePicker::make('start_date')
                        ->label(__('devices.export.date_range').' (Start)')
                        ->visible(fn ($get) => $get('export_type') === 'range')
                        ->required(fn ($get) => $get('export_type') === 'range'),
                    DatePicker::make('end_date')
                        ->label(__('devices.export.date_range').' (End)')
                        ->visible(fn ($get) => $get('export_type') === 'range')
                        ->required(fn ($get) => $get('export_type') === 'range'),
                ])
                ->visible(fn () => auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Hospital Admin', 'Technician'])),
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
                    Select::make('result')
                        ->label(__('devices.form.result.label'))
                        ->options([
                            'Laik Pakai' => 'Laik Pakai',
                            'Tidak Laik Pakai' => 'Tidak Laik Pakai',
                        ])
                        ->required(),
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

                    // Get the highest existing RENA number from DB to start after that
                    $maxNumber = DB::table('devices')
                        ->where('device_number', 'LIKE', 'RENA-%')
                        ->selectRaw('CAST(SUBSTRING(device_number, 6) AS UNSIGNED) as num')
                        ->orderByDesc('num')
                        ->value('num');

                    $startNumber = $maxNumber ? (int) ($maxNumber + 1) : 1;
                    $chunkSize = 100;

                    // Create an array of devices with device IDs and dispatch in chunks
                    for ($i = 0; $i < $numberOfQr; $i += $chunkSize) {
                        $chunkCount = min($chunkSize, $numberOfQr - $i);
                        $devices = [];

                        for ($j = 0; $j < $chunkCount; $j++) {
                            $devices[] = [
                                'deviceId' => (string) Str::orderedUuid(),
                                'result' => $data['result'],
                            ];
                        }

                        // Dispatch the job for this chunk
                        GenerateMultipleQRCodesJob::dispatch($devices, $startNumber + $i);
                    }

                    // Show success notification
                    \Filament\Notifications\Notification::make()
                        ->title(__('devices.generate.generate_success'))
                        ->success()
                        ->send();
                })
                ->visible(fn () => auth()->user()->hasAnyRole(['Super Admin', 'Admin'])),
            Action::make('import_devices')
                ->label(__('devices.import.label'))
                ->icon('heroicon-o-arrow-up-tray')
                ->color('warning')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('file')
                        ->label(__('devices.import.file'))
                        ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                        ->disk('public')
                        ->directory('imports')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $filePath = \Illuminate\Support\Facades\Storage::disk('public')->path($data['file']);

                    try {
                        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\DeviceImport, $filePath);

                        \Filament\Notifications\Notification::make()
                            ->title(__('devices.import.success'))
                            ->success()
                            ->send();
                    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                        $failures = $e->failures();
                        $errorMessage = '';
                        foreach ($failures as $failure) {
                            $errorMessage .= "Row {$failure->row()}: ".implode(', ', $failure->errors()).'. ';
                        }
                        \Filament\Notifications\Notification::make()
                            ->title(__('devices.import.fail'))
                            ->body($errorMessage)
                            ->danger()
                            ->persistent()
                            ->send();
                    } catch (\Exception $e) {
                        \Filament\Notifications\Notification::make()
                            ->title(__('devices.import.error'))
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->visible(fn () => auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Technician'])),
        ];
    }
}
