<?php

namespace App\Observers;

use App\Models\Device;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeviceObserver
{
    /**
     * Handle the Device "deleted" event.
     */
    public function deleted(Device $device): void
    {
        $this->syncSequence();
    }

    /**
     * Handle the Device "restoring" event (before bulk deletes).
     */
    public function restoring(Builder $query): void
    {
        // We'll sync after the bulk delete completes
        // For now, just log that a bulk delete is happening
        Log::info('Bulk device deletion started', [
            'query_hint' => $query->toSql(),
        ]);
    }

    /**
     * Sync device sequence to match actual max device number.
     */
    protected function syncSequence(): void
    {
        try {
            // Get current max device number (only proper format)
            $maxDeviceNum = Device::where('device_number', 'REGEXP', '^RENA-[0-9]+$')
                ->selectRaw('MAX(CAST(SUBSTRING(device_number, 6) AS UNSIGNED)) as max_num')
                ->value('max_num');

            // Calculate what next_value should be
            $shouldbeNextValue = $maxDeviceNum ? (int) $maxDeviceNum + 1 : 1;

            // Get current sequence value
            $currentValue = DB::table('device_sequences')
                ->where('sequence_name', 'device_number')
                ->value('next_value');

            // Only update if there's a difference
            if ($currentValue != $shouldbeNextValue) {
                DB::table('device_sequences')
                    ->where('sequence_name', 'device_number')
                    ->update([
                        'next_value' => $shouldbeNextValue,
                        'updated_at' => now(),
                    ]);

                Log::info('Device sequence synced', [
                    'old_value' => $currentValue,
                    'new_value' => $shouldbeNextValue,
                    'max_device_num' => $maxDeviceNum,
                    'reason' => $shouldbeNextValue < $currentValue ? 'max device deleted' : 'normal progression',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to sync device sequence', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
