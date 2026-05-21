<?php

namespace Tests\Feature;

use App\Imports\DeviceImport;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\Device;
use App\Models\DeviceName;
use App\Models\Province;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');

    // Seed roles
    Role::create(['name' => 'Admin']);
    Role::create(['name' => 'Super Admin']);
    Role::create(['name' => 'Technician']);

    // Create necessary data for relations
    $this->province = Province::create(['code' => '11', 'name' => 'ACEH']);
    $this->category = CustomerCategory::create(['name' => 'Test Category']);
    $this->customer = Customer::create([
        'name' => 'Test Customer',
        'type' => 'Swasta',
        'province_id' => $this->province->code,
        'categories_id' => $this->category->id,
    ]);
    $this->pic = User::factory()->create(['name' => 'Test PIC']);
});

function createTestExcel(array $rows, string $filename)
{
    $spreadsheet = new Spreadsheet;
    $sheet = $spreadsheet->getActiveSheet();

    $headings = [
        'No', 'Nomor QR', 'Nomor Pesanan', 'Nama Pemilik', 'Alamat Pemilik', 'Nama Alat',
        'Merk', 'Tipe', 'Nomor Seri', 'Hal', 'RUANG', 'Tanggal Penerimaan', 'PIC',
        'Tanggal Kalibrasi', 'Hasil Kalibrasi', 'Berlaku s/d', 'Tanggal Diterbitkan',
    ];
    $sheet->fromArray($headings, null, 'A1');
    $sheet->fromArray($rows, null, 'A2');

    $filePath = storage_path('app/'.$filename);
    $writer = new Xlsx($spreadsheet);
    $writer->save($filePath);

    return $filePath;
}

test('it can import new devices from excel', function () {
    $uuid = (string) Str::orderedUuid();
    $rows = [
        ['1', $uuid, 'ORD-001', 'Test Customer', 'Addr', 'Test Device', 'Test Brand', 'Test Type', 'SN-001', 'Hal', 'Room A', '2024-01-01', 'Test PIC', '2024-01-01', __('devices.form.result.options.fit_for_use'), '2025-01-01', '2024-01-01'],
    ];
    $filePath = createTestExcel($rows, 'test_import.xlsx');

    Excel::import(new DeviceImport, $filePath);

    $this->assertDatabaseHas('devices', [
        'deviceId' => $uuid,
        'device_number' => $uuid,
        'order_number' => 'ORD-001',
        'serial_number' => 'SN-001',
        'result' => __('devices.form.result.options.fit_for_use'),
    ]);

    $device = Device::where('device_number', $uuid)->first();
    expect($device->deviceName->name)->toBe('Test Device');
    expect($device->brand->name)->toBe('Test Brand');
    expect($device->type->name)->toBe('Test Type');
    expect($device->barcode)->toBe('qrcodes/'.$uuid.'.png');

    Storage::disk('public')->assertExists($device->barcode);

    unlink($filePath);
});

test('it updates existing devices based on device_number', function () {
    $device = Device::factory()->create([
        'device_number' => 'QR-002',
        'serial_number' => 'OLD-SN',
        'barcode' => null,
    ]);

    $rows = [
        ['1', 'QR-002', 'ORD-002', 'Test Customer', 'Addr', 'Test Device', 'Test Brand', 'Test Type', 'NEW-SN', 'Hal', 'Room A', '2024-01-01', 'Test PIC', '2024-01-01', __('devices.form.result.options.fit_for_use'), '2025-01-01', '2024-01-01'],
    ];

    $filePath = createTestExcel($rows, 'test_update.xlsx');

    Excel::import(new DeviceImport, $filePath);

    $device->refresh();

    expect($device->serial_number)->toBe('NEW-SN');
    expect($device->order_number)->toBe('ORD-002');
    expect($device->barcode)->not->toBeNull();

    Storage::disk('public')->assertExists($device->barcode);

    unlink($filePath);
});

test('it skips rows without device identifier', function () {
    $initialCount = Device::count();

    $rows = [
        ['1', '', 'ORD-003', 'Test Customer', 'Addr', 'Test Device', 'Test Brand', 'Test Type', 'SN-003', 'Hal', 'Room A', '2024-01-01', 'Test PIC', '2024-01-01', __('devices.form.result.options.fit_for_use'), '2025-01-01', '2024-01-01'],
    ];

    $filePath = createTestExcel($rows, 'test_skip_missing.xlsx');

    Excel::import(new DeviceImport, $filePath);

    expect(Device::count())->toBe($initialCount);

    unlink($filePath);
});

test('it skips rows if no changes are detected', function () {
    $deviceName = DeviceName::create(['name' => 'Static Device']);
    $brand = Brand::create(['name' => 'Static Brand']);
    $type = Type::create(['name' => 'Static Type', 'brand_id' => $brand->id]);

    $device = Device::create([
        'device_number' => 'QR-STATIC',
        'order_number' => 'ORD-STATIC',
        'device_name_id' => $deviceName->id,
        'brand_id' => $brand->id,
        'type_id' => $type->id,
        'customer_id' => $this->customer->id,
        'serial_number' => 'SN-STATIC',
        'calibration_date' => '2024-01-01',
        'next_calibration_date' => '2025-01-01',
        'result' => __('devices.form.result.options.fit_for_use'),
    ]);

    $rows = [
        ['1', 'QR-STATIC', 'ORD-STATIC', 'Test Customer', '', 'Static Device', 'Static Brand', 'Static Type', 'SN-STATIC', '', '', '', '', '2024-01-01', __('devices.form.result.options.fit_for_use'), '2025-01-01', ''],
    ];

    $filePath = createTestExcel($rows, 'test_skip_no_change.xlsx');

    Excel::import(new DeviceImport, $filePath);

    $device->refresh();

    expect($device->device_number)->toBe('QR-STATIC');

    unlink($filePath);
});

test('it validates data and reports errors', function () {
    $rows = [
        ['1', 'QR-ERR', 'ORD-ERR', 'Test Customer', '', 'Test Device', 'Test Brand', 'Test Type', 'SN-ERR', '', '', '', '', 'not-a-date', __('devices.form.result.options.fit_for_use'), '2025-01-01', ''],
    ];

    $filePath = createTestExcel($rows, 'test_error.xlsx');

    try {
        Excel::import(new DeviceImport, $filePath);
        $this->fail('Validation exception should have been thrown');
    } catch (ValidationException $e) {
        $failures = $e->failures();
        expect($failures)->toHaveCount(1);
        expect($failures[0]->attribute())->toBe('tanggal_kalibrasi');
    }

    $this->assertDatabaseMissing('devices', [
        'device_number' => 'DEV-ERR',
    ]);

    unlink($filePath);
});

test('it fills admin_id with logged in user if they are Admin', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');
    $this->actingAs($admin);

    $uuid = (string) Str::orderedUuid();
    $rows = [
        ['1', $uuid, 'ORD-001', 'Test Customer', 'Addr', 'Test Device', 'Test Brand', 'Test Type', 'SN-001', 'Hal', 'Room A', '2024-01-01', 'Test PIC', '2024-01-01', __('devices.form.result.options.fit_for_use'), '2025-01-01', '2024-01-01'],
    ];
    $filePath = createTestExcel($rows, 'test_admin_import.xlsx');

    Excel::import(new DeviceImport, $filePath);

    $this->assertDatabaseHas('devices', [
        'device_number' => $uuid,
        'admin_id' => $admin->id,
    ]);

    unlink($filePath);
});

test('it imports devices with same type name across different brands', function () {
    // This test verifies the fix for the slug uniqueness constraint on types.
    // Previously, types.slug had a GLOBAL unique constraint, but the app logic
    // treated it as unique PER BRAND. This caused a SQL constraint violation when
    // importing devices where the same type name existed for different brands.

    $uuid1 = (string) Str::orderedUuid();
    $uuid2 = (string) Str::orderedUuid();

    $rows = [
        // Row 1: Brand A with Type "Pro"
        ['1', $uuid1, 'ORD-010', 'Test Customer', 'Addr', 'Device One', 'Brand Alpha', 'Pro', 'SN-010', 'Hal', 'Room A', '2024-01-01', 'Test PIC', '2024-01-01', __('devices.form.result.options.fit_for_use'), '2025-01-01', '2024-01-01'],
        // Row 2: Brand B with Type "Pro" (same type name, different brand)
        ['2', $uuid2, 'ORD-011', 'Test Customer', 'Addr', 'Device Two', 'Brand Beta', 'Pro', 'SN-011', 'Hal', 'Room B', '2024-02-01', 'Test PIC', '2024-02-01', __('devices.form.result.options.fit_for_use'), '2025-02-01', '2024-02-01'],
    ];
    $filePath = createTestExcel($rows, 'test_cross_brand_type.xlsx');

    Excel::import(new DeviceImport, $filePath);

    // Both devices should be created
    $device1 = Device::where('device_number', $uuid1)->first();
    $device2 = Device::where('device_number', $uuid2)->first();

    expect($device1)->not->toBeNull();
    expect($device2)->not->toBeNull();

    // Each device should have its own brand
    expect($device1->brand->name)->toBe('Brand Alpha');
    expect($device2->brand->name)->toBe('Brand Beta');

    // Each device should have its own type, even though the type names are the same
    expect($device1->type->name)->toBe('Pro');
    expect($device2->type->name)->toBe('Pro');

    // Each type should be associated with a different brand
    expect($device1->type->brand_id)->toBe($device1->brand->id);
    expect($device2->type->brand_id)->toBe($device2->brand->id);

    // The two types should be different records (different IDs)
    expect($device1->type_id)->not->toBe($device2->type_id);

    unlink($filePath);
});

test('it fills pic_id with logged in user if they are Technician', function () {
    $technician = User::factory()->create();
    $technician->assignRole('Technician');
    $this->actingAs($technician);

    $uuid = (string) Str::orderedUuid();
    $rows = [
        ['1', $uuid, 'ORD-001', 'Test Customer', 'Addr', 'Test Device', 'Test Brand', 'Test Type', 'SN-001', 'Hal', 'Room A', '2024-01-01', 'Other PIC', '2024-01-01', __('devices.form.result.options.fit_for_use'), '2025-01-01', '2024-01-01'],
    ];
    $filePath = createTestExcel($rows, 'test_tech_import.xlsx');

    Excel::import(new DeviceImport, $filePath);

    $this->assertDatabaseHas('devices', [
        'device_number' => $uuid,
        'pic_id' => $technician->id,
    ]);

    unlink($filePath);
});
