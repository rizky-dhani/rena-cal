<?php

use App\Models\Device;
use App\Models\DeviceName;
use App\Models\User;
use App\Notifications\CalibrationRenewalNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

beforeEach(function () {
    App::setLocale('id');
});

it('can be instantiated with a collection of devices', function () {
    $devices = collect([new Device(['device_number' => 'DEV-001'])]);
    $notification = new CalibrationRenewalNotification($devices);

    expect($notification->devices)->toBeInstanceOf(Collection::class)
        ->and($notification->devices->first()->device_number)->toBe('DEV-001');
});

it('uses the mail channel', function () {
    $devices = collect([new Device(['device_number' => 'DEV-001'])]);
    $notification = new CalibrationRenewalNotification($devices);
    $user = new User();

    expect($notification->via($user))->toBe(['mail']);
});

it('renders the email content correctly', function () {
    $devices = collect([
        new Device([
            'device_number' => 'DEV-001',
            'serial_number' => 'SN-123',
            'next_calibration_date' => '2026-03-14',
        ]),
    ]);
    // We need to mock the deviceName relationship for the table
    $deviceName = new DeviceName(['name' => 'Test Device']);
    $devices->first()->setRelation('deviceName', $deviceName);

    $user = new User(['name' => 'John Doe']);
    $notification = new CalibrationRenewalNotification($devices);
    
    $mailData = $notification->toMail($user);
    $html = (string) $mailData->render();

    expect($html)->toContain('Halo John Doe')
        ->and($html)->toContain('Perangkat berikut memerlukan perpanjangan kalibrasi')
        ->and($html)->toContain('Test Device')
        ->and($html)->toContain('SN-123')
        ->and($html)->toContain('2026-03-14');
});
