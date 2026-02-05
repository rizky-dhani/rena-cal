# Design: Optimized QR Code Generation

## Implementation Details

### 1. Job Logic Refactoring (`GenerateMultipleQRCodesJob.php`)

The `handle` method will be refactored to move database lookups outside the loop and switch to SVG generation.

#### Initial Sequence Fetch
```php
$maxNumber = DB::table('devices')
    ->where('device_number', 'LIKE', 'RENA-%')
    ->selectRaw('CAST(SUBSTRING(device_number, 6) AS UNSIGNED) as num')
    ->orderByDesc('num')
    ->value('num');

$currentNumber = ($maxNumber ?: 0) + 1;
```

#### SVG Generation Loop
```php
foreach ($this->devices as $device) {
    $qr = new DNS2D;
    $content = route('devices.publicDetail', $device['deviceId']);
    
    // Generate SVG string
    $svgContent = $qr->getBarcodeSVG($content, 'QRCODE', 3, 3);
    $path = 'qrcodes/' . $device['deviceId'] . '.svg';
    
    Storage::disk('public')->put($path, $svgContent);
    
    $deviceNumber = 'RENA-' . str_pad($currentNumber, 5, '0', STR_PAD_LEFT);
    $currentNumber++;

    $devicesToInsert[] = [
        'deviceId' => $device['deviceId'],
        'device_number' => $deviceNumber,
        'barcode' => $path,
        'result' => $device['result'] ?? null,
        'created_at' => now(),
        'updated_at' => now(),
    ];
}
```

### 2. Service Update (`QRCodeService.php`)

Update `generateEmptyQRCode` to default to SVG and provide a more efficient bulk generation helper.

```php
public function generateEmptyQRCode(string $content = '', ?string $deviceId = null, string $format = 'svg'): string
{
    // ... logic to use getBarcodeSVG if format is svg
}
```

### 3. Database Constraints
The `device_number` and `deviceId` (UUID) should remain unique. By managing the increment in memory after fetching the initial `maxNumber`, we ensure uniqueness within the batch while drastically reducing query count.

## Alternatives Considered
- **On-the-fly rendering**: Rendering QR codes in the browser using a JS library or a dedicated route. This was rejected because the user requires physical files for export/printing workflows.
- **Chunked Processing**: For extremely large batches (e.g., > 10,000), we could split the job into smaller chunks. However, for "thousands", a single optimized job with bulk insert should be sufficient.

## Verification Plan
- **Unit Test**: Verify `QRCodeService` generates valid SVG files.
- **Feature Test**: Mock a large generation request (e.g., 100 QR codes) and assert that only one `SELECT` and one `INSERT` query are performed for the device records.
- **Performance Benchmark**: Measure the time difference between PNG/Sequential vs SVG/Bulk approaches.
