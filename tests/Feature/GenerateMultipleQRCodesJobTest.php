<?php

namespace Tests\Feature;

use App\Jobs\GenerateMultipleQRCodesJob;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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
    (new GenerateMultipleQRCodesJob($devices))->handle();

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

    (new GenerateMultipleQRCodesJob($devices))->handle();

    expect(Device::where('device_number', 'RENA-00011')->exists())->toBeTrue();
    expect(Device::where('device_number', 'RENA-00012')->exists())->toBeTrue();
});

it('handles gaps in sequence if necessary', function () {
    Device::factory()->create(['device_number' => 'RENA-00005']);
    Device::factory()->create(['device_number' => 'RENA-00010']);

    $devices = [
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
    ];

    (new GenerateMultipleQRCodesJob($devices))->handle();

    // The current logic gets the MAX and adds 1, so it will be RENA-00011
    expect(Device::where('device_number', 'RENA-00011')->exists())->toBeTrue();
});

it('uses provided startNumber for sequence', function () {
    $devices = [
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
    ];

    // Start from number 50
    (new GenerateMultipleQRCodesJob($devices, 50))->handle();

    expect(Device::where('device_number', 'RENA-00050')->exists())->toBeTrue();
    expect(Device::where('device_number', 'RENA-00051')->exists())->toBeTrue();
    expect(Device::where('device_number', 'RENA-00052')->exists())->toBeTrue();
});

it('handles chunked dispatch without race conditions', function () {
    // Simulate chunked dispatch like in ListDevices
    $maxNumber = DB::table('devices')
        ->where('device_number', 'LIKE', 'RENA-%')
        ->selectRaw('CAST(SUBSTRING(device_number, 6) AS UNSIGNED) as num')
        ->orderByDesc('num')
        ->value('num');

    $startNumber = $maxNumber ? (int) $maxNumber + 1 : 1;

    // Dispatch first chunk starting at $startNumber
    $chunk1 = [
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
    ];
    (new GenerateMultipleQRCodesJob($chunk1, $startNumber))->handle();

    // Dispatch second chunk starting at $startNumber + 2
    $chunk2 = [
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
    ];
    (new GenerateMultipleQRCodesJob($chunk2, $startNumber + 2))->handle();

    expect(Device::where('device_number', 'RENA-'.str_pad($startNumber, 5, '0', STR_PAD_LEFT))->exists())->toBeTrue();
    expect(Device::where('device_number', 'RENA-'.str_pad($startNumber + 1, 5, '0', STR_PAD_LEFT))->exists())->toBeTrue();
    expect(Device::where('device_number', 'RENA-'.str_pad($startNumber + 2, 5, '0', STR_PAD_LEFT))->exists())->toBeTrue();
});
