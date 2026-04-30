<?php

namespace App\Console\Commands;

use App\Models\Device;
use App\Models\User;
use App\Notifications\CalibrationRenewalNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendCalibrationRenewals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-calibration-renewals';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Find devices due for calibration in 60 days and notify Hospital Admins';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $targetDate = Carbon::now()->addDays(60)->format('Y-m-d');

        $devices = Device::with(['deviceName', 'customer'])
            ->whereDate('next_calibration_date', $targetDate)
            ->get();

        if ($devices->isEmpty()) {
            $this->info('No devices due for calibration in 60 days.');

            return;
        }

        $groupedDevices = $devices->groupBy('customer_id');

        foreach ($groupedDevices as $customerId => $customerDevices) {
            if (! $customerId) {
                continue;
            }

            $admins = User::role('Hospital Admin')
                ->where('customer_id', $customerId)
                ->get();

            if ($admins->isNotEmpty()) {
                Notification::send($admins, new CalibrationRenewalNotification($customerDevices));
                $this->info("Notifications sent to admins of customer ID: {$customerId}");
            } else {
                $this->warn("No Hospital Admins found for customer ID: {$customerId}");
            }
        }

        $this->info('Calibration renewal notifications process completed.');
    }
}
