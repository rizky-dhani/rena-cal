<?php

use App\Filament\Dashboard\Resources\Devices\Pages\ListDevices;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['name' => 'Super Admin']);
    Role::firstOrCreate(['name' => 'Admin']);
    Role::firstOrCreate(['name' => 'Technician']);
    Role::firstOrCreate(['name' => 'Hospital Admin']);
});

it('can see import devices action if Super Admin, Admin or Technician', function (string $roleName) {
    $user = User::factory()->create();
    $user->assignRole($roleName);

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->assertActionVisible('import_devices');
})->with(['Super Admin', 'Admin', 'Technician']);

it('cannot see import devices action if Hospital Admin', function () {
    $user = User::factory()->create();
    $user->assignRole('Hospital Admin');

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->assertActionHidden('import_devices');
});
