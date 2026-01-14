<?php

use App\Models\Customer;
use App\Models\Device;
use App\Models\User;
use App\Notifications\CalibrationRenewalNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Setup roles
    Role::create(['name' => 'Hospital Admin']);
});

it('sends calibration renewal notifications to hospital admins', function () {
    Notification::fake();

    $category = \App\Models\CustomerCategory::create([
        'name' => 'RSUD',
        'slug' => 'rsud',
    ]);

    $province = \App\Models\Province::create([
        'code' => 31,
        'name' => 'DKI JAKARTA',
    ]);

    $customer = Customer::create([
        'name' => 'Test Hospital',
        'type' => 'Swasta',
        'province_id' => $province->code,
        'categories_id' => $category->id,
    ]);
    
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@hospital.com',
        'password' => bcrypt('password'),
        'customer_id' => $customer->id,
    ]);
    $admin->assignRole('Hospital Admin');

    $otherAdmin = User::create([
        'name' => 'Other Admin',
        'email' => 'other@hospital.com',
        'password' => bcrypt('password'),
        'customer_id' => $customer->id,
    ]);
    $otherAdmin->assignRole('Hospital Admin');

    // Device due in 60 days
    $dueDevice1 = Device::create([
        'customer_id' => $customer->id,
        'device_number' => 'DEV-001',
        'next_calibration_date' => now()->addDays(60)->format('Y-m-d'),
    ]);

    $dueDevice2 = Device::create([
        'customer_id' => $customer->id,
        'device_number' => 'DEV-002',
        'next_calibration_date' => now()->addDays(60)->format('Y-m-d'),
    ]);

    // Device NOT due in 60 days
    Device::create([
        'customer_id' => $customer->id,
        'device_number' => 'DEV-003',
        'next_calibration_date' => now()->addDays(30)->format('Y-m-d'),
    ]);

    Artisan::call('app:send-calibration-renewals');

    Notification::assertSentTo(
        [$admin, $otherAdmin],
        CalibrationRenewalNotification::class,
        function ($notification) use ($dueDevice1, $dueDevice2) {
            return $notification->devices->count() === 2 &&
                   $notification->devices->contains($dueDevice1) &&
                   $notification->devices->contains($dueDevice2);
        }
    );
});

it('does not send notification if no devices are due in 60 days', function () {
    Notification::fake();

    $category = \App\Models\CustomerCategory::create([
        'name' => 'RSUD',
        'slug' => 'rsud',
    ]);

    $province = \App\Models\Province::create([
        'code' => 32,
        'name' => 'JAWA BARAT',
    ]);

    $customer = Customer::create([
        'name' => 'Test Hospital',
        'type' => 'Swasta',
        'province_id' => $province->code,
        'categories_id' => $category->id,
    ]);

    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@hospital.com',
        'password' => bcrypt('password'),
        'customer_id' => $customer->id,
    ]);
    $admin->assignRole('Hospital Admin');

    Device::create([
        'customer_id' => $customer->id,
        'device_number' => 'DEV-001',
        'next_calibration_date' => now()->addDays(59)->format('Y-m-d'),
    ]);

    Artisan::call('app:send-calibration-renewals');

    Notification::assertNothingSent();
});

it('is registered in the console schedule', function () {
    $schedule = app(\Illuminate\Console\Scheduling\Schedule::class);

    $event = collect($schedule->events())->first(function ($event) {
        return str_contains($event->command, 'app:send-calibration-renewals');
    });

    expect($event)->not->toBeNull()
        ->and($event->expression)->toBe('0 0 * * *'); // daily()
});
