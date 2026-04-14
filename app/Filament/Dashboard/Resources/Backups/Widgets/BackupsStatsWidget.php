<?php

namespace App\Filament\Dashboard\Resources\Backups\Widgets;

use App\Services\DatabaseBackupService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BackupsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $backupService = app(DatabaseBackupService::class);
        $stats = $backupService->getDiskUsage();

        return [
            Stat::make(__('backup.widgets.total_backups'), $stats['count'])
                ->description(__('backup.widgets.total_backups_desc'))
                ->icon('heroicon-o-cloud'),

            Stat::make(__('backup.widgets.disk_usage'), $stats['formatted_size'])
                ->description(__('backup.widgets.disk_usage_desc'))
                ->icon('heroicon-o-circle-stack')
                ->color('info'),
        ];
    }
}
