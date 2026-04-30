<?php

namespace App\Filament\Dashboard\Resources\Permissions\Pages;

use App\Filament\Dashboard\Resources\Permissions\PermissionResource;
use App\Services\GeneratePermissionsService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate_permissions')
                ->label(__('permissions.generate.title'))
                ->button()
                ->color('primary')
                ->action(function (): void {
                    $service = app(GeneratePermissionsService::class);
                    $generatedPermissions = $service->generate();

                    if (count($generatedPermissions) > 0) {
                        Notification::make()
                            ->title(fn () => count($generatedPermissions).__('permissions.generate.count_success'))
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title(__('permissions.generate.empty'))
                            ->danger()
                            ->send();
                    }
                })
                ->requiresConfirmation()
                ->modalHeading(__('permissions.generate.title'))
                ->modalDescription(__('permissions.generate.desc'))
                ->modalSubmitActionLabel(__('permissions.generate.button_label')),
            CreateAction::make()
                ->color('success')
                ->modalWidth(Width::SevenExtraLarge)
                ->successNotificationTitle(__('permissions.generate.success')),
        ];
    }
}
