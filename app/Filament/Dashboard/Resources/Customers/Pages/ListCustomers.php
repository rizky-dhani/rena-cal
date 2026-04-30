<?php

namespace App\Filament\Dashboard\Resources\Customers\Pages;

use App\Filament\Dashboard\Resources\Customers\CustomerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->color('success')
                ->modalWidth(Width::SevenExtraLarge)
                ->successNotificationTitle(__('customers.actions.create_success', ['label' => __('customers.label')])),
        ];
    }
}
