<?php

namespace App\Filament\Dashboard\Resources\CustomerCategories\Pages;

use Filament\Support\Enums\Width;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Dashboard\Resources\CustomerCategories\CustomerCategoriesResource;

class ListCustomerCategories extends ListRecords
{
    protected static string $resource = CustomerCategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->color('success')
                ->modalWidth(Width::SevenExtraLarge)
                ->successNotificationTitle(__('customer_categories.actions.create_success', ['label' => __('customer_categories.label')])),
        ];
    }
}
