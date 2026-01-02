<?php

namespace App\Filament\Dashboard\Resources\Customers\Pages;

use App\Filament\Dashboard\Resources\Customers\CustomerResource;
use App\Filament\Dashboard\Resources\Customers\Schemas\CustomerInfolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewCustomer extends ViewRecord
{
    protected static string $resource = CustomerResource::class;

    public function infolist(Schema $schema): Schema
    {
        return CustomerInfolist::configure($schema);
    }
}
