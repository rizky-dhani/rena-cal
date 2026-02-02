# Design: Status Selection in QR Generation

## Implementation Details

### Action Form Update
In `ListDevices.php`, the `generate_empty_qr` action will be updated to include a `Select` component:

```php
Select::make('result')
    ->label(__('devices.form.result.label'))
    ->options([
        'Laik Pakai' => 'Laik Pakai',
        'Tidak Laik Pakai' => 'Tidak Laik Pakai',
    ])
    ->required()
```

### Data Transfer
The `$devices` array passed to `GenerateMultipleQRCodesJob::dispatch($devices)` currently only contains `deviceId`. It will be updated to:

```php
$devices[] = [
    'deviceId' => $deviceId,
    'result' => $data['result'],
];
```

### Job Update
The `GenerateMultipleQRCodesJob@handle` method will be updated to extract the `result` from each device in the loop:

```php
$devicesToInsert[] = [
    'deviceId' => $device['deviceId'],
    'device_number' => $deviceNumber,
    'barcode' => $path,
    'result' => $device['result'] ?? null,
    'created_at' => now(),
    'updated_at' => now(),
];
```

## Alternatives Considered
- **Default value**: We could default to "Laik Pakai", but making it required forces the user to be explicit.
- **Model property**: We could set it as a model property if we were using Eloquent `create()`, but since the job uses `DB::table()->insert()`, we must pass it explicitly in the insert array.
