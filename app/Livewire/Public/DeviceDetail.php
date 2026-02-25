<?php

namespace App\Livewire\Public;

use App\Models\Device;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class DeviceDetail extends Component
{
    public Device $device;

    public $qrCodeExists = false;

    public function mount($deviceId)
    {
        // $this->device = Device::with(['deviceName', 'brand', 'type', 'pic', 'customer'])->findOrFail($deviceId);
        $this->device = Device::where('deviceId', $deviceId)->firstOrFail();

        // Check if QR code exists
        if ($this->device->barcode) {
            $this->qrCodeExists = Storage::disk('public')->exists($this->device->barcode);
        }
    }

    #[Title('Detail Perangkat')]
    #[Layout('components.layouts.public')]
    public function render()
    {
        return view('livewire.public.device-detail', [
            'device' => $this->device,
            'qrCodeExists' => $this->qrCodeExists,
        ]);
    }
}
