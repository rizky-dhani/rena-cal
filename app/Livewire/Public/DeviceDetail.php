<?php

namespace App\Livewire\Public;

use App\Models\Device;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class DeviceDetail extends Component
{
    public Device $device;

    public $qrCodeExists = false;

    public $showPasswordModal = false;

    public $enteredPassword = '';

    public $passwordError = '';

    public $certificateVerified = false;

    public $sessionError = '';

    public function mount($deviceId)
    {
        $this->device = Device::where('deviceId', $deviceId)->firstOrFail();

        if ($this->device->barcode) {
            $this->qrCodeExists = Storage::disk('public')->exists($this->device->barcode);
        }

        $this->sessionError = session()->pull('error', '');

        if ($this->sessionError && $this->device->cert_password) {
            $this->showPasswordModal = true;
        }

        $this->checkCertificateVerification();
    }

    protected function checkCertificateVerification()
    {
        if ($this->device->cert_password) {
            $sessionKey = 'cert_verified_'.$this->device->id;
            $this->certificateVerified = session()->get($sessionKey, false);
        } else {
            $this->certificateVerified = true;
        }
    }

    public function openCertificateWithPassword()
    {
        if (! $this->device->cert_password) {
            $this->certificateVerified = true;

            return;
        }

        $this->showPasswordModal = true;
    }

    public function verifyCertificatePassword()
    {
        $this->passwordError = '';

        if (! $this->enteredPassword) {
            $this->passwordError = 'Kata sandi tidak boleh kosong';

            return;
        }

        if (! Hash::check($this->enteredPassword, $this->device->cert_password)) {
            $this->passwordError = 'Kata sandi salah';
            $this->enteredPassword = '';

            return;
        }

        $sessionKey = 'cert_verified_'.$this->device->id;
        session()->put($sessionKey, true);
        session()->put('cert_verified_at_'.$this->device->id, now());

        $this->certificateVerified = true;
        $this->showPasswordModal = false;
        $this->enteredPassword = '';
    }

    public function closeModal()
    {
        $this->showPasswordModal = false;
        $this->enteredPassword = '';
        $this->passwordError = '';
    }

    #[Title('Detail Perangkat')]
    #[Layout('components.layouts.public')]
    public function render()
    {
        return view('livewire.public.device-detail', [
            'device' => $this->device,
            'qrCodeExists' => $this->qrCodeExists,
            'showPasswordModal' => $this->showPasswordModal,
            'passwordError' => $this->passwordError,
            'certificateVerified' => $this->certificateVerified,
            'sessionError' => $this->sessionError,
        ]);
    }
}
