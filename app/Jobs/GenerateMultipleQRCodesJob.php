<?php

namespace App\Jobs;

use App\Models\DeviceSequence;
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

        // Atomically reserve a block of sequence numbers for this job
        $currentNumber = DeviceSequence::getNext('device_number', count($this->devices));

        // Sanity check: ensure we're not creating duplicate device_numbers
        $existingMax = DB::table('devices')
            ->where('device_number', 'REGEXP', '^RENA-[0-9]+$')
            ->selectRaw('MAX(CAST(SUBSTRING(device_number, 6) AS UNSIGNED)) as max_num')
            ->value('max_num');

        if ($existingMax && $currentNumber <= $existingMax) {
            \Log::warning('Device sequence may be out of sync', [
                'sequence_value' => $currentNumber,
                'existing_max' => $existingMax,
                'action' => 'Using existing_max + 1 as starting point',
            ]);
            $currentNumber = (int) $existingMax + 1;
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
