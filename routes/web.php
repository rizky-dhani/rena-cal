<?php

use App\Models\Device;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Livewire\Public\DeviceDetail;
use Illuminate\Support\Facades\Route;

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
    $filePath = storage_path('app/public/' . $cert_number);

    if (file_exists($filePath)) {
        return response()->download($filePath);
    } else {
        abort(404, 'Certificate not found');
    }
})->name('certificate.download');

// QR Code Cards Print route
Route::get('/qr-print', function () {
    $ids = session()->get('qr_ids', []);

    $assets = Device::whereIn('id', $ids)->get();
    $filename = 'QR-RENA-' . now()->format('Y-m-d') . '.pdf';

    $pdf = Pdf::loadView('pdf.assets-list', compact('assets'))
        ->setPaper('A4')
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isRemoteEnabled', true);

    return $pdf->stream($filename);
})->name('devices.qr-print');
