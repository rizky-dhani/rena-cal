<?php

namespace App\Filament\Dashboard\Resources\Devices\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DeviceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(4)
                    ->columnSpanFull()
                    ->schema([
                        Section::make(__('devices.label'))
                            ->columns(5)
                            ->schema([
                                TextEntry::make('deviceName.name')
                                    ->label(__('devices.form.device_name_id.label')),
                                TextEntry::make('device_number')
                                    ->label(__('devices.form.device_number.label')),
                                TextEntry::make('serial_number')
                                    ->label(__('devices.form.serial_number.label')),
                                TextEntry::make('brand.name')
                                    ->label(__('devices.form.brand_id.label')),
                                TextEntry::make('type.name')
                                    ->label(__('devices.form.type_id.label')),
                                TextEntry::make('room_name')
                                    ->label(__('devices.form.room_name.label')),
                                TextEntry::make('customer.name')
                                    ->label(__('devices.form.customer_id.label')),
                                TextEntry::make('pic.name')
                                    ->label(__('devices.form.user_id.label')),
                                TextEntry::make('procurement_year')
                                    ->label(__('devices.form.procurement_year.label')),
                                TextEntry::make('notes')
                                    ->label(__('devices.form.notes.label'))
                                    ->columnSpanFull()
                                    ->placeholder(__('devices.form.notes.empty')),
                            ])
                            ->columnSpan(3),

                        Section::make(__('devices.detail.cal_info'))
                            ->schema([
                                TextEntry::make('calibration_date')
                                    ->label(__('devices.form.calibration_date.label'))
                                    ->date('d/m/Y'),
                                TextEntry::make('next_calibration_date')
                                    ->label(__('devices.form.next_calibration_date.label'))
                                    ->date('d/m/Y'),
                                TextEntry::make('cert_number')
                                    ->label(__('devices.form.cert_number.label'))
                                    ->url(fn ($state) => $state ? route('certificate.download', ['cert_number' => $state]) : null)
                                    ->openUrlInNewTab(),
                                TextEntry::make('result')
                                    ->label(__('devices.form.result.label'))
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Laik Pakai' => 'success',
                                        'Tidak Laik Pakai' => 'danger',
                                        default => 'gray',
                                    }),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }
}
