<?php

namespace App\Filament\Dashboard\Widgets;

use App\Models\Device;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class DeviceStatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getHeading(): string
    {
        return __('widgets.device_stats.heading');
    }

    protected function getStats(): array
    {
        $user = auth()->user();

        // Base query with customer filter for Hospital Admin
        $baseQuery = Device::query();
        if ($user && $user->hasRole('Hospital Admin') && $user->customer_id) {
            $baseQuery->where('customer_id', $user->customer_id);
        }

        $totalDevices = $baseQuery->count();

        // Terisi - all key fields filled including cert_number
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
            ->whereNotNull('cert_number');

        if ($user && $user->hasRole('Hospital Admin') && $user->customer_id) {
            $filledDevices->where('customer_id', $user->customer_id);
        }
        $filledDevices = $filledDevices->count();

        // Belum Terisi - ALL key fields are NULL
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

        // Terisi Sebagian - NOT empty AND NOT fully filled
        $partiallyFilledDevices = $totalDevices - $filledDevices - $emptyDevices;

        return [
            Stat::make(__('widgets.device_stats.total_devices'), Number::format($totalDevices))
                ->descriptionIcon(Heroicon::ComputerDesktop)
                ->color('info'),

            Stat::make(__('widgets.qr.filled'), Number::format($filledDevices))
                ->descriptionIcon(Heroicon::CheckCircle)
                ->color('success'),

            Stat::make(__('widgets.qr.partial'), Number::format($partiallyFilledDevices))
                ->descriptionIcon(Heroicon::Clock)
                ->color('warning'),

            Stat::make(__('widgets.qr.empty'), Number::format($emptyDevices))
                ->descriptionIcon(Heroicon::ExclamationTriangle)
                ->color('danger'),
        ];
    }

    protected function getColumns(): int|array
    {
        return 4;
    }

    public static function canView(): bool
    {
        $user = auth()->user();

        // Only show this widget to users with Customer Admin role
        return $user && $user->hasRole('Customer Admin') || $user->hasRole(roles: 'Super Admin');
    }
}
