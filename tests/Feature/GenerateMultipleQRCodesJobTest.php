<?php

namespace Tests\Feature;

use App\Jobs\GenerateMultipleQRCodesJob;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
});

it('generates multiple QR codes efficiently', function () {
    $count = 10;
    $devices = [];
    for ($i = 0; $i < $count; $i++) {
        $devices[] = [
            'deviceId' => (string) Str::orderedUuid(),
            'result' => 'Laik Pakai',
        ];
    }

    // Measure time/queries if we wanted to be fancy, but let's just check correctness first
    (new GenerateMultipleQRCodesJob($devices, 1))->handle();

    expect(Device::count())->toBe($count);

    $allDevices = Device::orderBy('device_number')->get();

    foreach ($allDevices as $index => $device) {

        $expectedNumber = 'RENA-'.str_pad($index + 1, 5, '0', STR_PAD_LEFT);

        expect($device->device_number)->toBe($expectedNumber);

        expect($device->barcode)->toEndWith('.png');

        Storage::disk('public')->assertExists($device->barcode);

        $content = Storage::disk('public')->get($device->barcode);

        // Basic check for PNG signature

        expect($content)->toStartWith("\x89PNG");

    }
});

it('continues sequence from existing devices', function () {
    // Create existing devices
    Device::factory()->create(['device_number' => 'RENA-00010']);

    $devices = [
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
    ];

    (new GenerateMultipleQRCodesJob($devices, 11))->handle();

    expect(Device::where('device_number', 'RENA-00011')->exists())->toBeTrue();
    expect(Device::where('device_number', 'RENA-00012')->exists())->toBeTrue();
});

it('handles gaps in sequence if necessary', function () {
    Device::factory()->create(['device_number' => 'RENA-00005']);
    Device::factory()->create(['device_number' => 'RENA-00010']);

    $devices = [
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
    ];

    (new GenerateMultipleQRCodesJob($devices, 11))->handle();

    // The current logic gets the MAX and adds 1, so it will be RENA-00011
    expect(Device::where('device_number', 'RENA-00011')->exists())->toBeTrue();
});
