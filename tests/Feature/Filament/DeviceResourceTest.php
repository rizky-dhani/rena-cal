<?php

use App\Filament\Dashboard\Resources\Devices\Pages\ListDevices;
use App\Models\User;
use App\Models\Device;
use App\Models\Customer;
use App\Models\Province;
use App\Models\CustomerCategory;
use App\Notifications\CalibrationRenewalNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Setup roles if they don't exist
    Role::firstOrCreate(['name' => 'Super Admin']);
    Role::firstOrCreate(['name' => 'Admin']);
    Role::firstOrCreate(['name' => 'Hospital Admin']);
    Role::firstOrCreate(['name' => 'Technician']);
});

it('can see the manual renewal action if authorized', function (string $roleName) {
    $user = User::factory()->create();
    $user->assignRole($roleName);

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->assertActionVisible('send_renewal_manual');
})->with(['Super Admin', 'Admin']);

it('cannot see the manual renewal action if not authorized', function (string $roleName) {
    $user = User::factory()->create();
    $user->assignRole($roleName);

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->assertActionHidden('send_renewal_manual');
})->with(['Hospital Admin', 'Technician']);

it('can trigger the manual renewal action', function () {
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
        ->callAction('send_renewal_manual');

    Notification::assertSentTo($hospitalAdmin, CalibrationRenewalNotification::class);
});
