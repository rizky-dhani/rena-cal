<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'Technician']);
    Role::create(['name' => 'Admin']);
});

it('attributes pic_id when a technician updates a device', function () {
    $technician = User::factory()->create();
    $technician->assignRole('Technician');

    $device = Device::factory()->create(['pic_id' => null]);

    $this->actingAs($technician);

    $device->update(['serial_number' => 'NEW-SN-123']);

    expect($device->fresh()->pic_id)->toBe($technician->id);
});

it('attributes admin_id when an admin updates a device', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $device = Device::factory()->create(['admin_id' => null]);

    $this->actingAs($admin);

    $device->update(['serial_number' => 'ADMIN-UPDATED']);

    expect($device->fresh()->admin_id)->toBe($admin->id);
});

it('does not change pic_id if updated by non-technician', function () {
    $user = User::factory()->create();
    // No specific roles

    $device = Device::factory()->create(['pic_id' => null]);

    $this->actingAs($user);

    $device->update(['serial_number' => 'USER-UPDATED']);

    expect($device->fresh()->pic_id)->toBeNull();
});
