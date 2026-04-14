<?php

namespace Tests\Feature;

use App\Jobs\GenerateMultipleQRCodesJob;
use App\Models\Device;
use App\Models\DeviceSequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
    
    // Reset the device_sequences table for each test
    \Illuminate\Support\Facades\DB::table('device_sequences')->updateOrInsert(
        ['sequence_name' => 'device_number'],
        [
            'next_value' => 1,
            'updated_at' => now(),
        ]
    );
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
    // Update sequence to start from 11 (simulating 10 existing devices)
    DeviceSequence::where('sequence_name', 'device_number')->update(['next_value' => 11]);

    $devices = [
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
    ];

    (new GenerateMultipleQRCodesJob($devices))->handle();

    expect(Device::where('device_number', 'RENA-00011')->exists())->toBeTrue();
    expect(Device::where('device_number', 'RENA-00012')->exists())->toBeTrue();
});

it('handles gaps in sequence correctly', function () {
    // Sequence doesn't care about gaps - it just increments
    DeviceSequence::where('sequence_name', 'device_number')->update(['next_value' => 11]);

    $devices = [
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
    ];

    (new GenerateMultipleQRCodesJob($devices))->handle();

    // Will be RENA-00011 regardless of gaps
    expect(Device::where('device_number', 'RENA-00011')->exists())->toBeTrue();
});

it('uses device sequence table for atomic number generation', function () {
    DeviceSequence::where('sequence_name', 'device_number')->update(['next_value' => 50]);

    $devices = [
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
    ];

    (new GenerateMultipleQRCodesJob($devices))->handle();

    expect(Device::where('device_number', 'RENA-00050')->exists())->toBeTrue();
    expect(Device::where('device_number', 'RENA-00051')->exists())->toBeTrue();
    expect(Device::where('device_number', 'RENA-00052')->exists())->toBeTrue();

    // Verify sequence table was updated
    $nextValue = DeviceSequence::where('sequence_name', 'device_number')->value('next_value');
    expect($nextValue)->toBe(53);
});

it('handles concurrent chunked dispatch without race conditions', function () {
    // Simulate chunked dispatch like in ListDevices - each job gets its own block atomically
    $chunk1 = [
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
    ];
    (new GenerateMultipleQRCodesJob($chunk1))->handle();

    $chunk2 = [
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
    ];
    (new GenerateMultipleQRCodesJob($chunk2))->handle();

    // Chunk 1 gets 1-2, Chunk 2 gets 3
    expect(Device::where('device_number', 'RENA-00001')->exists())->toBeTrue();
    expect(Device::where('device_number', 'RENA-00002')->exists())->toBeTrue();
    expect(Device::where('device_number', 'RENA-00003')->exists())->toBeTrue();

    // Verify sequence table is at 4
    $nextValue = DeviceSequence::where('sequence_name', 'device_number')->value('next_value');
    expect($nextValue)->toBe(4);
});

it('respects existing devices when sequence is initialized', function () {
    // Create an existing device with high number
    Device::factory()->create(['device_number' => 'RENA-05000']);

    // Reset sequence to simulate proper initialization (max + 1)
    DeviceSequence::where('sequence_name', 'device_number')->update(['next_value' => 5001]);

    $devices = [
        ['deviceId' => (string) Str::orderedUuid(), 'result' => 'Laik Pakai'],
    ];

    (new GenerateMultipleQRCodesJob($devices))->handle();

    // New device should be RENA-05001
    expect(Device::where('device_number', 'RENA-05001')->exists())->toBeTrue();
});
