<?php

namespace App\Filament\Dashboard\Resources\Provinces\Pages;

use App\Models\Province;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Dashboard\Resources\Provinces\ProvinceResource;

class ListProvinces extends ListRecords
{
    protected static string $resource = ProvinceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('import_from_api')
                ->label(__('provinces.buttons.import.label'))
                ->requiresConfirmation()
                ->action(function() {
                    $response = Http::get('https://wilayah.id/api/provinces.json');

                    if ($response->successful()) {
                        $apiProvinces = $response->json('data', []);

                        // Insert provinces from the API
                        foreach ($apiProvinces as $provinceData) {
                            Province::create([
                                'code' => $provinceData['code'],
                                'name' => $provinceData['name'],
                            ]);
                        }

                        Notification::make()
                            ->title(__('provinces.notifications.import_success.title'))
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title(__('provinces.notifications.import_error.title'))
                            ->body(__('provinces.notifications.import_error.body'))
                            ->danger()
                            ->send();
                    }
                }),
            CreateAction::make()
                ->label(__('provinces.buttons.create.label'))
                ->successNotificationTitle(__('provinces.notifications.success', ['label' => __('provinces.label')]))
        ];
    }
}
