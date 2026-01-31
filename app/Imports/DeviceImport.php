<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\Device;
use App\Models\DeviceName;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
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
        if (! empty($row['tipe']) && $brandId) {
            $typeId = Type::firstOrCreate(['name' => $row['tipe'], 'brand_id' => $brandId])->id;
        }

        // Customer lookup, creating record if it doesn't exist
        $customerId = ! empty($row['nama_pemilik']) ? Customer::firstOrCreate(['name' => $row['nama_pemilik']])->id : null;

        // PIC: Find by name
        $picId = ! empty($row['pic']) ? User::where('name', $row['pic'])->first()?->id : null;

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
            'cert_number' => $row['tanggal_diterbitkan'] ?? null,
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

            if (! $changed) {
                return null;
            }

            // Update existing device
            $device->update($data);

            return null;
        }

        // Create new device
        $newDevice = new Device($data);
        $newDevice->device_number = $deviceNumber;

        // If nomor_qr is a valid UUID, use it as deviceId
        if (\Illuminate\Support\Str::isUuid($deviceNumber)) {
            $newDevice->deviceId = $deviceNumber;
        }

        return $newDevice;
    }

    public function rules(): array
    {
        return [
            'nomor_qr' => 'nullable',
            'nomor_pesanan' => 'nullable',
            'tanggal_kalibrasi' => 'nullable|date',
            'berlaku_sd' => 'nullable|date',
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
