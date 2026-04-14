<?php

namespace App\Filament\Dashboard\Resources\Backups\Pages;

use App\Filament\Dashboard\Resources\BackupsResource;
use Filament\Resources\Pages\ListRecords;

class ListBackups extends ListRecords
{
    protected static string $resource = BackupsResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            BackupsStatsWidget::class,
        ];
    }
}
