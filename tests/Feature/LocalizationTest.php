<?php

use Illuminate\Support\Facades\App;

beforeEach(function () {
    App::setLocale('id');
});

it('has core translation files', function () {
    $files = [
        'brands',
        'customer_categories',
        'customers',
        'devicenames',
        'devices',
        'locations',
        'navigation',
        'passwords',
        'permissions',
        'provinces',
        'roles',
        'types',
        'users',
        'widgets',
    ];

    foreach ($files as $file) {
        $path = lang_path("id/{$file}.php");
        expect(file_exists($path))->toBeTrue("Translation file {$file}.php missing in lang/id/");
    }
});

it('translates core entity labels', function () {
    expect(__('devices.label'))->not->toBe('devices.label');
    expect(__('brands.label'))->not->toBe('brands.label');
    expect(__('locations.label'))->not->toBe('locations.label');
});

it('translates navigation group labels', function () {
    expect(__('navigation.Devices'))->not->toBe('navigation.Devices');
    expect(__('navigation.Admin Management'))->not->toBe('navigation.Admin Management');
    expect(__('navigation.User Management'))->not->toBe('navigation.User Management');
});

it('translates device columns', function () {
    expect(__('devices.columns.deviceId'))->not->toBe('devices.columns.deviceId');
    expect(__('devices.columns.serial_number'))->not->toBe('devices.columns.serial_number');
});

it('translates auth messages', function () {
    expect(__('auth.failed'))->not->toBe('auth.failed');
    expect(__('auth.failed'))->toBe('Kredensial ini tidak cocok dengan data kami.');
});

it('translates pagination labels', function () {
    expect(__('pagination.next'))->not->toBe('pagination.next');
    expect(__('pagination.next'))->toContain('Berikutnya');
});

it('translates validation messages', function () {
    expect(__('validation.required', ['attribute' => 'nama']))->not->toBe('validation.required');
    expect(__('validation.required', ['attribute' => 'nama']))->toBe('nama wajib diisi.');
});
