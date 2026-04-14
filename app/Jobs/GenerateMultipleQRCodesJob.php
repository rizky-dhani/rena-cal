<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS2D;

class GenerateMultipleQRCodesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $devices;
    public $startNumber;

    /**
     * Create a new job instance.
     */
    public function __construct($devices, $startNumber = null)
    {
        $this->devices = $devices;
        $this->startNumber = $startNumber;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $devicesToInsert = [];

        // Use provided startNumber or calculate from database (for backward compatibility)
        if ($this->startNumber !== null) {
            $currentNumber = (int) $this->startNumber;
        } else {
            // Get the current max device number at execution time to avoid race conditions
            $maxNumber = DB::table('devices')
                ->where('device_number', 'LIKE', 'RENA-%')
                ->selectRaw('CAST(SUBSTRING(device_number, 6) AS UNSIGNED) as num')
                ->orderByDesc('num')
                ->value('num');

            $currentNumber = $maxNumber ? (int) $maxNumber + 1 : 1;
        }

        $qr = new DNS2D;

        foreach ($this->devices as $device) {
            try {
                // Generate unique device number with template RENA- followed by 5 digits zero-padded
                $deviceNumber = 'RENA-'.str_pad($currentNumber, 5, '0', STR_PAD_LEFT);
                $currentNumber++;

                // Generate QR code content and path
                $content = route('devices.publicDetail', $device['deviceId']);
                $path = 'qrcodes/'.$device['deviceId'].'.png';

                // Generate PNG QR code
                $qrCodePng = $qr->getBarcodePNG($content, 'QRCODE');
                Storage::disk('public')->put($path, base64_decode($qrCodePng));

                // Prepare device data for insertion
                $devicesToInsert[] = [
                    'deviceId' => $device['deviceId'],
                    'device_number' => $deviceNumber,
                    'barcode' => $path,
                    'result' => $device['result'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } catch (\Exception $e) {
                // Error handling could be added here
            }
        }

        // Insert the devices into the database if we have any to insert
        if (! empty($devicesToInsert)) {
            DB::table('devices')->insert($devicesToInsert);
        }
    }
}
