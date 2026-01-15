<?php

namespace Tests\Feature\Filament;

use App\Filament\Dashboard\Resources\Devices\Pages\ListDevices;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\Device;
use App\Models\Province;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Setup roles if they don't exist
    Role::firstOrCreate(['name' => 'Super Admin']);
    Role::firstOrCreate(['name' => 'Admin']);
    Role::firstOrCreate(['name' => 'Hospital Admin']);
    Role::firstOrCreate(['name' => 'Technician']);
});

it('can see export actions if authorized', function (string $roleName) {
    $user = User::factory()->create();
    $user->assignRole($roleName);

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->assertActionVisible('export')
        ->assertTableBulkActionVisible('export');
})->with(['Super Admin', 'Admin', 'Hospital Admin']);

it('cannot see export actions if not authorized', function () {
    $user = User::factory()->create();
    $user->assignRole('Technician');

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->assertActionHidden('export')
        ->assertTableBulkActionHidden('export');
});

it('can trigger bulk export', function () {
    $user = User::factory()->create();
    $user->assignRole('Admin');

    $device = Device::factory()->create();

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->callTableBulkAction('export', [$device]);
});

it('can trigger header export with all records', function () {
    $user = User::factory()->create();
    $user->assignRole('Admin');

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->fillForm([
            'export_type' => 'all',
        ])
        ->callAction('export');
});

it('can trigger header export with date range', function () {
    $user = User::factory()->create();
    $user->assignRole('Admin');

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->fillForm([
            'export_type' => 'range',
            'date_field' => 'calibration_date',
            'start_date' => '2025-01-01',
            'end_date' => '2025-03-31',
        ])
        ->callAction('export');
});

it('scopes export for hospital admins', function () {
    $category = CustomerCategory::firstOrCreate(['name' => 'RS', 'slug' => 'rs']);
    $province = Province::firstOrCreate(['code' => 31, 'name' => 'Jakarta']);

    $customer1 = Customer::create(['name' => 'Hospital A', 'province_id' => $province->code, 'categories_id' => $category->id]);
    $customer2 = Customer::create(['name' => 'Hospital B', 'province_id' => $province->code, 'categories_id' => $category->id]);

    $hospitalAdmin = User::factory()->create(['customer_id' => $customer1->id]);
    $hospitalAdmin->assignRole('Hospital Admin');

    $device1 = Device::factory()->create(['customer_id' => $customer1->id]);
    $device2 = Device::factory()->create(['customer_id' => $customer2->id]);

    Livewire::actingAs($hospitalAdmin)
        ->test(ListDevices::class)
        ->assertCanSeeTableRecords([$device1])
        ->assertCanNotSeeTableRecords([$device2])
        ->fillForm(['export_type' => 'all'])
        ->callAction('export');

    // Note: pxlrbt/filament-excel exports use the table query, which is already scoped in DevicesTable.php
});
