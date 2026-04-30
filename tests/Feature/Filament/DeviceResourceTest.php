<?php

use App\Filament\Dashboard\Resources\Devices\Pages\ListDevices;
use App\Filament\Dashboard\Resources\Devices\Pages\ViewDevice;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\Device;
use App\Models\Province;
use App\Models\User;
use App\Notifications\CalibrationRenewalNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
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

it('can see the toolbar renewal action if authorized and filter active', function (string $roleName, string $filterName) {
    $user = User::factory()->create();
    $user->assignRole($roleName);

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->filterTable($filterName, true)
        ->assertTableActionVisible('send_renewal_toolbar');
})->with(['Super Admin', 'Admin'])->with(['more_than_60_days', 'within_60_days']);

it('cannot see the toolbar renewal action if authorized but no filter active', function (string $roleName) {
    $user = User::factory()->create();
    $user->assignRole($roleName);

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->assertTableActionHidden('send_renewal_toolbar');
})->with(['Super Admin', 'Admin']);

it('can see the bulk renewal action if authorized and no filter active', function (string $roleName) {
    $user = User::factory()->create();
    $user->assignRole($roleName);

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->assertTableBulkActionVisible('send_renewal_bulk');
})->with(['Super Admin', 'Admin']);

it('cannot see the bulk renewal action if authorized but filter active', function (string $roleName, string $filterName) {
    $user = User::factory()->create();
    $user->assignRole($roleName);

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->filterTable($filterName, true)
        ->assertTableBulkActionHidden('send_renewal_bulk');
})->with(['Super Admin', 'Admin'])->with(['more_than_60_days', 'within_60_days']);

it('cannot see the toolbar renewal action if not authorized', function (string $roleName) {
    $user = User::factory()->create();
    $user->assignRole($roleName);

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->filterTable('within_60_days', true)
        ->assertTableActionHidden('send_renewal_toolbar');
})->with(['Hospital Admin', 'Technician']);

it('can trigger the manual renewal action from toolbar', function () {
    Notification::fake();

    $user = User::factory()->create();
    $user->assignRole('Super Admin');

    $category = CustomerCategory::firstOrCreate(['name' => 'RS', 'slug' => 'rs']);
    $province = Province::firstOrCreate(['code' => 31, 'name' => 'Jakarta']);
    $customer = Customer::create([
        'name' => 'Test Hospital',
        'type' => 'Swasta',
        'province_id' => $province->code,
        'categories_id' => $category->id,
    ]);

    $hospitalAdmin = User::factory()->create(['customer_id' => $customer->id]);
    $hospitalAdmin->assignRole('Hospital Admin');

    // Device due in 60 days
    Device::create([
        'customer_id' => $customer->id,
        'device_number' => 'DEV-MAN-001',
        'next_calibration_date' => now()->addDays(60)->format('Y-m-d'),
    ]);

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->filterTable('within_60_days', true)
        ->callTableAction('send_renewal_toolbar');

    Notification::assertSentTo($hospitalAdmin, CalibrationRenewalNotification::class);
});

it('can trigger the manual renewal action from bulk actions', function () {
    Notification::fake();

    $user = User::factory()->create();
    $user->assignRole('Super Admin');

    $category = CustomerCategory::firstOrCreate(['name' => 'RS', 'slug' => 'rs']);
    $province = Province::firstOrCreate(['code' => 31, 'name' => 'Jakarta']);
    $customer = Customer::create([
        'name' => 'Test Hospital',
        'type' => 'Swasta',
        'province_id' => $province->code,
        'categories_id' => $category->id,
    ]);

    $hospitalAdmin = User::factory()->create(['customer_id' => $customer->id]);
    $hospitalAdmin->assignRole('Hospital Admin');

    $device = Device::create([
        'customer_id' => $customer->id,
        'device_number' => 'DEV-BULK-001',
        'next_calibration_date' => now()->addDays(100)->format('Y-m-d'),
    ]);

    Livewire::actingAs($user)

        ->test(ListDevices::class)

        ->callTableBulkAction('send_renewal_bulk', [$device]);

    Notification::assertSentTo($hospitalAdmin, CalibrationRenewalNotification::class);

});

it('can see the renewal action on view page if authorized and date is valid', function (string $roleName) {

    $user = User::factory()->create();

    $user->assignRole($roleName);

    $device = Device::create([

        'device_number' => 'VIEW-TEST-001',

        'next_calibration_date' => now()->addDays(10)->format('Y-m-d'),

    ]);

    Livewire::actingAs($user)

        ->test(ViewDevice::class, ['record' => $device->deviceId])

        ->assertActionVisible('send_renewal_view');

})->with(['Super Admin', 'Admin']);

it('cannot see the renewal action on view page if device is overdue', function () {

    $user = User::factory()->create();

    $user->assignRole('Super Admin');

    $device = Device::create([

        'device_number' => 'VIEW-TEST-002',

        'next_calibration_date' => now()->subDay()->format('Y-m-d'),

    ]);

    Livewire::actingAs($user)

        ->test(ViewDevice::class, ['record' => $device->deviceId])

        ->assertActionHidden('send_renewal_view');

});

it('can trigger the renewal action on view page', function () {

    Notification::fake();

    $user = User::factory()->create();

    $user->assignRole('Super Admin');

    $category = CustomerCategory::firstOrCreate(['name' => 'RS', 'slug' => 'rs']);

    $province = Province::firstOrCreate(['code' => 31, 'name' => 'Jakarta']);

    $customer = Customer::create([

        'name' => 'Test Hospital',

        'type' => 'Swasta',

        'province_id' => $province->code,

        'categories_id' => $category->id,

    ]);

    $hospitalAdmin = User::factory()->create(['customer_id' => $customer->id]);

    $hospitalAdmin->assignRole('Hospital Admin');

    $device = Device::create([

        'customer_id' => $customer->id,

        'device_number' => 'VIEW-TEST-003',

        'next_calibration_date' => now()->addDays(10)->format('Y-m-d'),

    ]);

    Livewire::actingAs($user)

        ->test(ViewDevice::class, ['record' => $device->deviceId])

        ->callAction('send_renewal_view');

    Notification::assertSentTo($hospitalAdmin, CalibrationRenewalNotification::class);

});
