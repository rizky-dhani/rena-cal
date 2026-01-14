<?php

namespace App\Filament\Dashboard\Resources\Devices\Widgets;

use App\Models\Device;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DevicesWidget extends StatsOverviewWidget
{
    protected function getHeading(): ?string
    {
        return __('widgets.qr.title');
    }

    protected ?string $pollingInterval = null;
    protected function getStats(): array
    {
        // Count total devices
        $totalDevices = Device::count();

        // Count filled devices - where all non-exception fields are not null
        $filledDevices = Device::whereNotNull('device_name_id')
            ->whereNotNull('device_number')
            ->whereNotNull('brand_id')
            ->whereNotNull('type_id')
            ->whereNotNull('serial_number')
            ->whereNotNull('room_name')
            ->whereNotNull('procurement_year')
            ->whereNotNull('pic_id')
            ->whereNotNull('customer_id')
            ->whereNotNull('calibration_date')
            ->whereNotNull('next_calibration_date')
            ->whereNotNull('cert_number')
            ->count();

        // Count empty devices - where all non-exception fields are null
        $emptyDevices = Device::whereNull('device_name_id')
            ->whereNull('brand_id')
            ->whereNull('type_id')
            ->whereNull('serial_number')
            ->whereNull('room_name')
            ->whereNull('procurement_year')
            ->whereNull('pic_id')
            ->whereNull('customer_id')
            ->whereNull('calibration_date')
            ->whereNull('next_calibration_date')
            ->whereNull('cert_number')
            ->count();

        // Count partially filled devices - where some but not all non-exception fields are null
        $partiallyFilledDevices = $totalDevices - $filledDevices - $emptyDevices;

        return [
            Stat::make(__('widgets.qr.total'), $totalDevices)
                ->description(__('widgets.qr.unit'))
                ->color('primary')
                ->url(\App\Filament\Dashboard\Resources\Devices\DeviceResource::getUrl('index')),

            Stat::make(__('widgets.qr.filled'), $filledDevices)
                ->description(__('widgets.qr.unit'))
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->url(\App\Filament\Dashboard\Resources\Devices\DeviceResource::getUrl('index', [
                    'filters' => [
                        'filled' => [
                            'isActive' => 'true'
                        ],
                        'empty' => [
                            'isActive' => 'false'
                        ],
                    ],
                ])),

            Stat::make(__('widgets.qr.partial'), $partiallyFilledDevices)
                ->description(__('widgets.qr.unit'))
                ->descriptionIcon('heroicon-m-minus-circle')
                ->color('warning')
                ->url(\App\Filament\Dashboard\Resources\Devices\DeviceResource::getUrl('index', [
                    'filters' => [
                        'partially_filled' => [
                            'isActive' => 'true'
                        ],
                    ],
                ])),

            Stat::make(__('widgets.qr.empty'), $emptyDevices)
                ->description(__('widgets.qr.unit'))
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger')
                ->url(\App\Filament\Dashboard\Resources\Devices\DeviceResource::getUrl('index', [
                    'filters' => [
                        'filled' => [
                            'isActive' => 'false'
                        ],
                        'empty' => [
                            'isActive' => 'true'
                        ],
                    ],
                ])),
        ];
    }
}