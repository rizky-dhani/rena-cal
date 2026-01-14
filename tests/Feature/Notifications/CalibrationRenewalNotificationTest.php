<?php

use App\Models\Device;
use App\Models\User;
use App\Notifications\CalibrationRenewalNotification;
use Illuminate\Support\Collection;

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
