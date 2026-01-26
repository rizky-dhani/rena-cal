<?php

use App\Livewire\Public\DeviceDetail;
use App\Models\Device;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/devices/details/{deviceId}', DeviceDetail::class)->name('devices.show');
// Redirect old device detail page to new device detail page
Route::get('/devices/{deviceId}', function ($deviceId) {
    return redirect()->route('devices.show', ['deviceId' => $deviceId]);
})->name('devices.publicDetail');

// Certificate download route
Route::get('/certificate/download/{cert_number}', function ($cert_number) {
    // Block any attempts to traverse directories using ".."
    if (str_contains($cert_number, '..')) {
        abort(403, 'Invalid path');
    }

    $disk = \Illuminate\Support\Facades\Storage::disk('public');

    if ($disk->exists($cert_number)) {
        return $disk->download($cert_number);
    }

    abort(404, 'Certificate not found');
})->name('certificate.download')->where('cert_number', '.*');

// QR Code Cards Print route
Route::get('/qr-print', function () {
    $ids = session()->get('qr_ids', []);
    $size = session()->get('qr_size', 'v1');

    $assets = Device::whereIn('id', $ids)->get();
    $filename = 'Calibration-Labels-'.now()->format('Y-m-d').'.pdf';

    $pdf = Pdf::loadView('pdf.asset-calibration-labels', compact('assets', 'size'))
        ->setPaper('A4');

    return $pdf->stream($filename);
})->name('devices.qr-print');
