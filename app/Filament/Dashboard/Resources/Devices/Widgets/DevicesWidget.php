<?php

namespace App\Filament\Dashboard\Resources\Devices\Widgets;

use App\Filament\Dashboard\Resources\Devices\DeviceResource;
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
        $user = auth()->user();
        $query = Device::query();

        if ($user && $user->hasRole('Hospital Admin') && $user->customer_id) {
            $query->where('customer_id', $user->customer_id);
        }

        $totalDevices = $query->count();

        $filledDevices = Device::whereNotNull('device_name_id')
            ->whereNotNull('device_number')
            ->whereNotNull('brand_id')
            ->whereNotNull('type_id')
            ->whereNotNull('serial_number')
            ->whereNotNull('room_name')
            ->whereNotNull('pic_id')
            ->whereNotNull('customer_id')
            ->whereNotNull('calibration_date')
            ->whereNotNull('next_calibration_date')
            ->whereNotNull('cert_number'); // Certificate must be uploaded

        if ($user && $user->hasRole('Hospital Admin') && $user->customer_id) {
            $filledDevices->where('customer_id', $user->customer_id);
        }

        $filledDevices = $filledDevices->count();

        // Empty devices - ALL key fields are NULL
        $emptyDevices = Device::whereNull('order_number')
            ->whereNull('brand_id')
            ->whereNull('type_id')
            ->whereNull('serial_number')
            ->whereNull('customer_id')
            ->whereNull('calibration_date')
            ->whereNull('next_calibration_date')
            ->whereNull('cert_number')
            ->whereNull('cert_password')
            ->whereNull('device_name_id')
            ->whereNull('room_name');

        if ($user && $user->hasRole('Hospital Admin') && $user->customer_id) {
            $emptyDevices->where('customer_id', $user->customer_id);
        }

        $emptyDevices = $emptyDevices->count();

        // Count partially filled devices - NOT empty AND NOT fully filled
        // Uses same key fields as emptyDevices: order_number, brand_id, type_id, serial_number, customer_id, calibration_date, next_calibration_date
        $partiallyFilledDevices = $totalDevices - $filledDevices - $emptyDevices;

        return [
            Stat::make(__('widgets.qr.total'), $totalDevices)
                ->description(__('widgets.qr.unit'))
                ->color('primary')
                ->url(DeviceResource::getUrl('index')),

            Stat::make(__('widgets.qr.filled'), $filledDevices)
                ->description(__('widgets.qr.unit'))
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->url(DeviceResource::getUrl('index', [
                    'filters' => [
                        'filled' => [
                            'isActive' => 'true',
                        ],
                        'empty' => [
                            'isActive' => 'false',
                        ],
                    ],
                ])),

            Stat::make(__('widgets.qr.partial'), $partiallyFilledDevices)
                ->description(__('widgets.qr.unit'))
                ->descriptionIcon('heroicon-m-minus-circle')
                ->color('warning')
                ->url(DeviceResource::getUrl('index', [
                    'filters' => [
                        'partially_filled' => [
                            'isActive' => 'true',
                        ],
                    ],
                ])),

            Stat::make(__('widgets.qr.empty'), $emptyDevices)
                ->description(__('widgets.qr.unit'))
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger')
                ->url(DeviceResource::getUrl('index', [
                    'filters' => [
                        'filled' => [
                            'isActive' => 'false',
                        ],
                        'empty' => [
                            'isActive' => 'true',
                        ],
                    ],
                ])),
        ];
    }
}
