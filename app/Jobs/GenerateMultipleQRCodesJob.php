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

    /**
     * Create a new job instance.
     */
    public function __construct($devices)
    {
        $this->devices = $devices;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $devicesToInsert = [];

        foreach ($this->devices as $index => $device) {
            try {
                // Generate QR code and path
                $qr = new DNS2D;
                $content = route('devices.publicDetail', $device['deviceId']);

                $qrCodePng = $qr->getBarcodePNG($content, 'QRCODE');
                $path = 'qrcodes/'.$device['deviceId'].'.png';

                Storage::disk('public')->put($path, base64_decode($qrCodePng));

                // Generate unique device number with template RENA- followed by 6 digits zero-padded
                // Find the next available number sequentially for this device

                // Get the highest existing RENA number from DB to start after that
                $maxNumber = DB::table('devices')
                    ->where('device_number', 'LIKE', 'RENA-%')
                    ->selectRaw('CAST(SUBSTRING(device_number, 6) AS UNSIGNED) as num')
                    ->orderByDesc('num')
                    ->value('num');

                // Start checking from the next number after the highest existing number
                $currentNumber = $maxNumber ? $maxNumber + 1 : 1;

                $deviceNumber = 'RENA-'.str_pad($currentNumber, 5, '0', STR_PAD_LEFT);

                // Keep looking for the next available number that doesn't exist in DB or the current batch
                while (DB::table('devices')->where('device_number', $deviceNumber)->exists() ||
                       in_array($deviceNumber, array_column($devicesToInsert, 'device_number'))) {
                    $currentNumber++;
                    $deviceNumber = 'RENA-'.str_pad($currentNumber, 5, '0', STR_PAD_LEFT);
                }

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
                // In a production environment, you might want to log this error
                // \Log::error('Error generating QR code', ['error' => $e->getMessage()]);
            }
        }

        // Insert the devices into the database if we have any to insert
        if (! empty($devicesToInsert)) {
            DB::table('devices')->insert($devicesToInsert);
        }
    }
}
