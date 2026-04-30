<?php

namespace App\Filament\Dashboard\Resources\Roles\Pages;

use App\Filament\Dashboard\Resources\Roles\RoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->color('success')
                ->modalWidth(Width::SevenExtraLarge)
                ->successNotificationTitle(__('roles.actions.create_success', ['label' => __('roles.label')])),
        ];
    }
}
