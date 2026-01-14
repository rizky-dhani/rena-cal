<?php

use App\Filament\Dashboard\Resources\Provinces\Pages\ListProvinces;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['name' => 'Super Admin']);
    Role::firstOrCreate(['name' => 'Admin']);
    Role::firstOrCreate(['name' => 'Technician']);
});

it('allows Super Admin to view provinces', function () {
    $user = User::factory()->create();
    $user->assignRole('Super Admin');

    Livewire::actingAs($user)
        ->test(ListProvinces::class)
        ->assertStatus(200);
});

it('does not allow Admin to view provinces', function () {
    $user = User::factory()->create();
    $user->assignRole('Admin');

    Livewire::actingAs($user)
        ->test(ListProvinces::class)
        ->assertStatus(403);
});

it('does not allow Technician to view provinces', function () {
    $user = User::factory()->create();
    $user->assignRole('Technician');

    Livewire::actingAs($user)
        ->test(ListProvinces::class)
        ->assertStatus(403);
});
