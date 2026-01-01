<?php

namespace App\Filament\Dashboard\Resources\Users\Pages;

use App\Filament\Dashboard\Resources\Users\UserResource;
use App\Imports\UserImport;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use Maatwebsite\Excel\Facades\Excel;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('import_users')
                ->label(__('users.import_users'))
                ->button()
                ->modalWidth(Width::Large)
                ->form([
                    FileUpload::make('import_file')
                        ->label(__('users.form.import.label'))
                        ->required()
                        ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/vnd.ms-excel'])
                        ->maxSize(10240) // 10MB
                        ->disk('local')
                        ->directory('imports')
                        ->visibility('private')
                        ->helperText(__('users.actions.import_helper'))
                        ->columnSpanFull(),
                ])
                ->action(function (array $data): void {
                    try {
                        $import = new UserImport;
                        $filePath = $data['import_file'];

                        // Check if the file exists in storage
                        if (! \Storage::exists($filePath)) {
                            throw new \Exception(__('users.actions.import_file_not_found').': '.$filePath);
                        }

                        Excel::import($import, $filePath);

                        Notification::make()
                            ->title(__('users.actions.import_success', ['plural_label' => __('users.label')]))
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title(__('users.actions.import_failed'))
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->modalHeading(__('users.import_users'))
                ->modalDescription(__('users.actions.import_modal_desc'))
                ->modalSubmitActionLabel(__('users.actions.import_modal_submit')),
            CreateAction::make()
                ->color('success')
                ->modalWidth(Width::SevenExtraLarge)
                ->successNotificationTitle(__('users.actions.create_success', ['label' => __('users.label')])),
        ];
    }
}
