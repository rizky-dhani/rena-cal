<?php

namespace App\Console\Commands;

use App\Models\Device;
use App\Models\DeviceSequence;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncDeviceSequenceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:sync-sequence {--dry-run : Show what would be synced without actually updating}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync device sequence table with actual max device number';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking device sequence...');

        // Get current sequence value
        $sequence = DeviceSequence::where('sequence_name', 'device_number')->first();

        if (!$sequence) {
            $this->error('Device sequence not found! Please run the migration first.');
            return Command::FAILURE;
        }

        $currentValue = (int) $sequence->next_value;

        // Get actual max device number
        $maxDeviceNum = Device::where('device_number', 'REGEXP', '^RENA-[0-9]+$')
            ->selectRaw('MAX(CAST(SUBSTRING(device_number, 6) AS UNSIGNED)) as max_num')
            ->value('max_num');

        $shouldbeNextValue = $maxDeviceNum ? (int) $maxDeviceNum + 1 : 1;

        $this->table(
            ['Metric', 'Value'],
            [
                ['Current Sequence Value', $currentValue],
                ['Actual Max Device Number', $maxDeviceNum ?? 'None'],
                ['Should Be Next Value', $shouldbeNextValue],
            ]
        );

        if ($currentValue == $shouldbeNextValue) {
            $this->info('✓ Sequence is already in sync. No changes needed.');
            return Command::SUCCESS;
        }

        if ($currentValue > $shouldbeNextValue) {
            $diff = $currentValue - $shouldbeNextValue;
            $this->warn("⚠ Sequence is AHEAD by {$diff} number(s). It will be reduced.");
        } else {
            $diff = $shouldbeNextValue - $currentValue;
            $this->warn("⚠ Sequence is behind by {$diff} number(s).");
        }

        if ($this->option('dry-run')) {
            $this->info('[DRY RUN] Would update sequence from ' . $currentValue . ' to ' . $shouldbeNextValue);
            return Command::SUCCESS;
        }

        if (!$this->confirm('Do you want to sync the sequence now?')) {
            $this->info('Sync cancelled.');
            return Command::SUCCESS;
        }

        try {
            // Directly sync to match actual max device number
            DB::table('device_sequences')
                ->where('sequence_name', 'device_number')
                ->update([
                    'next_value' => $shouldbeNextValue,
                    'updated_at' => now(),
                ]);

            $newValue = DeviceSequence::where('sequence_name', 'device_number')->value('next_value');

            $this->info("✓ Sequence synced successfully!");
            $this->line("  From: {$currentValue}");
            $this->line("  To:   {$newValue}");

            Log::info('Device sequence manually synced via artisan command', [
                'old_value' => $currentValue,
                'new_value' => $newValue,
                'max_device_num' => $maxDeviceNum,
            ]);

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to sync sequence: ' . $e->getMessage());
            Log::error('Device sequence sync failed via artisan command', [
                'error' => $e->getMessage(),
            ]);
            return Command::FAILURE;
        }
    }
}
