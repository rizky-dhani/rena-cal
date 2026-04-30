<?php

namespace App\Filament\Dashboard\Widgets;

use App\Models\Customer;
use App\Models\Device;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class RecordCountWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getHeading(): string
    {
        return __('widgets.record_count.heading');
    }

    protected function getStats(): array
    {
        $deviceCount = Device::count();
        $customerCount = Customer::count();

        return [
            Stat::make(__('widgets.record_count.total_devices'), Number::format($deviceCount))
                ->descriptionIcon(Heroicon::ComputerDesktop)
                ->color('info'),

            Stat::make(__('widgets.record_count.total_customers'), Number::format($customerCount))
                ->descriptionIcon(Heroicon::UserGroup)
                ->color('success'),
        ];
    }

    protected function getColumns(): int|array
    {
        return 2;
    }

    public static function canView(): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        // Return true only if user does NOT have Admin or Super Admin role
        return ! $user->hasRole(['Super Admin', 'Admin']);
    }
}
