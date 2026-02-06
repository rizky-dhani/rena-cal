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
    Role::firstOrCreate(['name' => 'Hospital Admin']);
});

it('can see generate empty qr action if Super Admin or Admin', function (string $roleName) {
    $user = User::factory()->create();
    $user->assignRole($roleName);

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->assertActionVisible('generate_empty_qr');
})->with(['Super Admin', 'Admin']);

it('cannot see generate empty qr action if Hospital Admin', function () {
    $user = User::factory()->create();
    $user->assignRole('Hospital Admin');

    Livewire::actingAs($user)
        ->test(ListDevices::class)
        ->assertActionHidden('generate_empty_qr');
});
