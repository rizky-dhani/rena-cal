<?php

namespace App\Filament\Dashboard\Resources\Devices\Pages;

use App\Filament\Dashboard\Resources\Devices\DeviceResource;
use App\Filament\Dashboard\Resources\Devices\Schemas\DeviceInfolist;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewDevice extends ViewRecord
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->color('info')
                ->visible(fn ($record) => auth()->id() === $record->pic_id || auth()->user()->hasAnyRole(['Admin', 'Super Admin'])),
            Actions\DeleteAction::make()
                ->color('danger')
                ->visible(fn ($record) => auth()->id() === $record->pic_id || auth()->user()->hasAnyRole(['Admin', 'Super Admin'])),
            Actions\Action::make('public_detail')
                ->label(__('devices.actions.public_detail'))
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->openUrlInNewTab()
                ->url(fn ($record) => route('devices.publicDetail', $record->deviceId)),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return DeviceInfolist::configure($schema);
    }
}
