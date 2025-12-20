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
        // Total devices
        $totalDevices = Device::count();

        // Total calibrated devices (devices where next_calibration_date is in the future)
        $totalCalibrated = Device::whereDate('next_calibration_date', '>', now())->count();

        // Total overdue devices (devices where next_calibration_date is today or in the past)
        $totalOverdue = Device::whereDate('next_calibration_date', '<=', now())->count();

        return [
            Stat::make(__('widgets.device_stats.total_devices'), Number::format($totalDevices))
                ->descriptionIcon(Heroicon::ComputerDesktop)
                ->color('info'),

            Stat::make(__('widgets.device_stats.total_calibrated'), Number::format($totalCalibrated))
                ->descriptionIcon(Heroicon::CheckCircle)
                ->color('success'),

            Stat::make(__('widgets.device_stats.total_overdue'), Number::format($totalOverdue))
                ->descriptionIcon(Heroicon::ExclamationTriangle)
                ->color('danger'),
        ];
    }

    protected function getColumns(): int|array
    {
        return 3;
    }

    public static function canView(): bool
    {
        $user = auth()->user();

        // Only show this widget to users with Customer Admin role
        return $user && $user->hasRole('Customer Admin') || $user->hasRole(roles: 'Super Admin');
    }
}