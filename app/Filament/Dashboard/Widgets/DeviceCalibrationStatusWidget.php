<?php

namespace App\Filament\Dashboard\Widgets;

use App\Models\Device;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class DeviceCalibrationStatusWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getHeading(): string
    {
        return __('widgets.device_calibration_status.heading');
    }

    protected function getStats(): array
    {
        // Devices with next_calibration_date more than 60 days from today (well in advance)
        $moreThan60Days = Device::whereDate('next_calibration_date', '>', now()->addDays(60))->count();

        // Devices with next_calibration_date within 60 days from today (approaching)
        $within60Days = Device::whereDate('next_calibration_date', '<=', now()->addDays(60))
                              ->whereDate('next_calibration_date', '>', now())
                              ->count();

        // Devices with next_calibration_date overdue (past due)
        $overdue = Device::whereDate('next_calibration_date', '<=', now())->count();

        return [
            Stat::make(__('widgets.device_calibration_status.more_than_60_days'), Number::format($moreThan60Days))
                ->descriptionIcon(Heroicon::CheckCircle)
                ->color('success'),

            Stat::make(__('widgets.device_calibration_status.within_60_days'), Number::format($within60Days))
                ->descriptionIcon(Heroicon::Clock)
                ->color('warning'),

            Stat::make(__('widgets.device_calibration_status.overdue'), Number::format($overdue))
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