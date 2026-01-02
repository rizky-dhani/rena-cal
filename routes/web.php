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

    $assets = Device::whereIn('id', $ids)->get();
    $filename = 'QR-RENA-'.now()->format('Y-m-d').'.pdf';

    $pdf = Pdf::loadView('pdf.asset-list-new', compact('assets'))
        ->setPaper('A4');
    // ->setOption('isHtml5ParserEnabled', true)
    // ->setOption('isRemoteEnabled', true)

    // $html = view('pdf.asset-list-new', compact('assets'));
    // $pdf = Browsershot::html($html)
    //     ->noSandbox()
    //     ->format('A4')
    //     ->showBackground()
    //     ->pdf();

    return $pdf->stream($filename);
    // return response($pdf, 200)
    //     ->header('Content-Type', 'application/pdf')
    //     ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
})->name('devices.qr-print');
