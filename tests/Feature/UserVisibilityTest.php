<?php

use App\Filament\Dashboard\Resources\Users\Pages\ListUsers;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\Province;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['name' => 'Super Admin']);
    Role::firstOrCreate(['name' => 'Hospital Admin']);
    Role::firstOrCreate(['name' => 'Admin']);
});

it('shows the customer field when Hospital Admin role is selected', function () {
    $user = User::factory()->create();
    $user->assignRole('Super Admin');

    $hospitalAdminRole = Role::where('name', 'Hospital Admin')->first();

    Livewire::actingAs($user)
        ->test(ListUsers::class)
        ->mountAction('create')
        ->set('mountedActions.0.data.roles', [$hospitalAdminRole->id])
        ->assertFormFieldVisible('customer_id');
});

it('hides the customer field when Hospital Admin role is not selected', function () {
    $user = User::factory()->create();
    $user->assignRole('Super Admin');

    $adminRole = Role::where('name', 'Admin')->first();

    Livewire::actingAs($user)
        ->test(ListUsers::class)
        ->mountAction('create')
        ->set('mountedActions.0.data.roles', [$adminRole->id])
        ->assertFormFieldHidden('customer_id');
});

it('requires customer_id when Hospital Admin role is selected', function () {
    $user = User::factory()->create();
    $user->assignRole('Super Admin');

    $hospitalAdminRole = Role::where('name', 'Hospital Admin')->first();

    Livewire::actingAs($user)
        ->test(ListUsers::class)
        ->mountAction('create')
        ->set('mountedActions.0.data.roles', [$hospitalAdminRole->id])
        ->set('mountedActions.0.data.name', 'New User')
        ->set('mountedActions.0.data.email', 'new@example.com')
        ->set('mountedActions.0.data.initial', 'NU')
        ->set('mountedActions.0.data.customer_id', null)
        ->callMountedAction()
        ->assertHasFormErrors(['customer_id' => 'required']);
});

it('does not require customer_id when Hospital Admin role is not selected', function () {
    $user = User::factory()->create();
    $user->assignRole('Super Admin');

    $adminRole = Role::where('name', 'Admin')->first();

    Livewire::actingAs($user)
        ->test(ListUsers::class)
        ->mountAction('create')
        ->set('mountedActions.0.data.roles', [$adminRole->id])
        ->set('mountedActions.0.data.name', 'New User')
        ->set('mountedActions.0.data.email', 'new@example.com')
        ->set('mountedActions.0.data.initial', 'NU')
        ->set('mountedActions.0.data.customer_id', null)
        ->callMountedAction()
        ->assertHasNoFormErrors(['customer_id']);
});

it('saves customer_id when Hospital Admin role is selected', function () {
    $user = User::factory()->create();
    $user->assignRole('Super Admin');

    $hospitalAdminRole = Role::where('name', 'Hospital Admin')->first();

    $category = CustomerCategory::firstOrCreate(['name' => 'RS', 'slug' => 'rs']);
    $province = Province::firstOrCreate(['code' => 31, 'name' => 'Jakarta']);
    $customer = Customer::create([
        'name' => 'Test Hospital',
        'type' => 'Swasta',
        'province_id' => $province->code,
        'categories_id' => $category->id,
    ]);

    Livewire::actingAs($user)
        ->test(ListUsers::class)
        ->mountAction('create')
        ->set('mountedActions.0.data.roles', [$hospitalAdminRole->id])
        ->set('mountedActions.0.data.name', 'Hospital Admin User')
        ->set('mountedActions.0.data.email', 'hospital@example.com')
        ->set('mountedActions.0.data.initial', 'HAU')
        ->set('mountedActions.0.data.customer_id', $customer->id)
        ->callMountedAction()
        ->assertHasNoFormErrors();

    $newUser = User::where('email', 'hospital@example.com')->first();
    expect($newUser)->not->toBeNull()
        ->and($newUser->customer_id)->toBe($customer->id);
    expect($newUser->hasRole('Hospital Admin'))->toBeTrue();
});

it('shows customer field when editing a user with Hospital Admin role', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Super Admin');

    $hospitalAdminRole = Role::where('name', 'Hospital Admin')->first();
    $targetUser = User::factory()->create();
    $targetUser->assignRole('Hospital Admin');

    Livewire::actingAs($admin)
        ->test(ListUsers::class)
        ->mountTableAction('edit', $targetUser)
        ->assertFormFieldVisible('customer_id');
});
