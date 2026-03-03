<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\Device;
use App\Models\DeviceName;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Milon\Barcode\DNS2D;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DeviceImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Requirement: device_number is used as data identifier (mapped from nomor_qr)
        $deviceNumber = $row['nomor_qr'] ?? null;

        if (empty($deviceNumber)) {
            return null;
        }

        // Map names to IDs, creating related records if they don't exist (where possible)
        $deviceNameId = ! empty($row['nama_alat']) ? DeviceName::firstOrCreate(['name' => $row['nama_alat']])->id : null;
        $brandId = ! empty($row['merk']) ? Brand::firstOrCreate(['name' => $row['merk']])->id : null;

        // Type requires brand_id
        $typeId = null;
        $typeName = $row['tipe'] ?? '';
        if (! empty($typeName) && trim($typeName) !== '-' && $brandId) {
            $typeId = Type::firstOrCreate(['name' => $typeName, 'brand_id' => $brandId])->id;
        }

        // Customer lookup, creating record if it doesn't exist
        $customerId = ! empty($row['nama_pemilik']) ? Customer::firstOrCreate(['name' => $row['nama_pemilik']])->id : null;

        // Determine pic_id based on logged-in user role
        $user = auth()->user();
        $picId = ! empty($row['pic']) ? User::where('name', $row['pic'])->first()?->id : null;

        if ($user && $user->hasRole('Technician')) {
            $picId = $user->id;
        }

        $calibrationDate = $this->transformDate($row['tanggal_kalibrasi'] ?? null);
        $nextCalibrationDate = $this->transformDate($row['berlaku_sd'] ?? null);

        // Map result back to key
        $result = $this->transformResult($row['hasil_kalibrasi'] ?? null);

        $data = [
            'device_name_id' => $deviceNameId,
            'brand_id' => $brandId,
            'type_id' => $typeId,
            'customer_id' => $customerId,
            'pic_id' => $picId,
            'serial_number' => $row['nomor_seri'] ?? null,
            'order_number' => $row['nomor_pesanan'] ?? null,
            'calibration_date' => $calibrationDate,
            'next_calibration_date' => $nextCalibrationDate,
            'result' => $result,
            'room_name' => $row['ruang'] ?? null,
        ];

        $device = Device::where('device_number', $deviceNumber)->first();

        if ($device) {
            // Requirement: Skip Row Due to Already Filled Fields
            // Check if any fields changed
            $changed = false;
            foreach ($data as $key => $value) {
                // Handle date comparison carefully
                $currentValue = $device->$key;
                if ($currentValue instanceof Carbon) {
                    $currentValue = $currentValue->format('Y-m-d');
                }

                $compareValue = $value;
                if ($compareValue instanceof Carbon) {
                    $compareValue = $compareValue->format('Y-m-d');
                }

                if ($currentValue != $compareValue) {
                    $changed = true;
                    break;
                }
            }

            if (! $changed && ! empty($device->barcode)) {
                return null;
            }

            // Update existing device
            $device->update($data);

            // Generate barcode if missing
            if (empty($device->barcode)) {
                $device->barcode = $this->generateQRCode($device->deviceId);
                $device->save();
            }

            return null;
        }

        // Create new device
        $newDevice = new Device($data);
        $newDevice->device_number = $deviceNumber;

        // If nomor_qr is a valid UUID, use it as deviceId
        if (Str::isUuid($deviceNumber)) {
            $newDevice->deviceId = $deviceNumber;
        } else {
            $newDevice->deviceId = (string) Str::orderedUuid();
        }

        // Generate barcode
        $newDevice->barcode = $this->generateQRCode($newDevice->deviceId);

        return $newDevice;
    }

    /**
     * Generate QR code for the device
     */
    private function generateQRCode(string $deviceId): string
    {
        $qr = new DNS2D;
        $content = route('devices.publicDetail', $deviceId);
        $qrCodePng = $qr->getBarcodePNG($content, 'QRCODE');
        $path = 'qrcodes/'.$deviceId.'.png';

        Storage::disk('public')->put($path, base64_decode($qrCodePng));

        return $path;
    }

    public function rules(): array
    {
        return [
            'nomor_qr' => 'nullable',
            'nomor_pesanan' => 'nullable',
            'tanggal_kalibrasi' => 'nullable|date',
            'berlaku_sd' => 'nullable|date',
            'pic' => 'nullable|string',
        ];
    }

    /**
     * @param  mixed  $value
     * @return string|null
     */
    private function transformDate($value)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof \Carbon\CarbonInterface) {
            return $value->format('Y-m-d');
        }

        if (is_numeric($value)) {
            return Carbon::instance(Date::excelToDateTimeObject($value))->format('Y-m-d');
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param  mixed  $value
     * @return string|null
     */
    private function transformResult($value)
    {
        if (empty($value)) {
            return null;
        }

        $fit = __('devices.form.result.options.fit_for_use');
        $notFit = __('devices.form.result.options.not_fit_for_use');

        if ($value === $fit) {
            return $fit;
        }

        if ($value === $notFit) {
            return $notFit;
        }

        return $value;
    }
}
