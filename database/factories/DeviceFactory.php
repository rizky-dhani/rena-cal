<?php

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {
        return [
            'deviceId' => (string) Str::orderedUuid(),
            'device_number' => $this->faker->unique()->bothify('DEV-####'),
            'serial_number' => $this->faker->bothify('SN-####'),
            'calibration_date' => now()->subMonths(6)->format('Y-m-d'),
            'next_calibration_date' => now()->addMonths(6)->format('Y-m-d'),
        ];
    }
}
