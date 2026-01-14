<div class="container mx-auto px-4 py-8 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full max-w-4xl">
        <div class="flex flex-col md:flex-row">
            <!-- Left Column - QR Code with Logo -->
            <div class="md:w-1/2 p-6 sm:p-8">
                <div class="bg-white rounded-lg shadow p-6 h-full flex flex-col">
                    <div class="flex flex-col items-center justify-center flex-1">
                        <!-- Rena Logo -->
                        <div class="mb-4">
                            <img src="{{ asset('assets/images/logos/Rena-Logo.webp') }}"
                                 alt="Rena Logo"
                                 class="mx-auto max-w-[150px] sm:max-w-[180px] md:max-w-[300px] h-auto object-contain">
                        </div>

                        <!-- QR Code -->
                        @if($device->deviceId)
                            @if($qrCodeExists)
                                @php
        $qrCodePath = 'qrcodes/' . $device->deviceId . '.png';
                                @endphp
                                <img src="{{ asset('storage/' . $qrCodePath) }}" alt="Device QR Code" class="mx-auto max-w-full h-auto rounded border border-gray-200 p-2">
                            @else
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 sm:p-8 text-center w-full">
                                    <p class="text-sm text-gray-400 mt-2">{{ __('devices.detail.qr_not_available') }}</p>
                                </div>
                            @endif
                        @else
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 sm:p-8 text-center w-full">
                                <p class="text-sm text-gray-400 mt-2">{{ __('devices.detail.no_device_id') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Device Details -->
            <div class="md:w-1/2 p-6 sm:p-8">
                <div class="bg-white rounded-lg shadow p-6 h-full flex flex-col">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-6">
                        <div class="w-full sm:w-auto mb-2 sm:mb-0">
                            <span class="sm:hidden px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium inline-block text-center mx-auto mb-3">
                                {{ $device->status }}
                            </span>
                            <p class="text-2xl text-black font-bold mt-1">{{ $device->deviceName->name ?? 'N/A' }}</p>
                        </div>
                        <span class="hidden sm:inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium self-start">
                            {{ $device->status }}
                        </span>
                    </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('devices.form.device_number.label') }}</h3>
                        <p class="mt-1 text-gray-900">{{ $device->device_number ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('devices.form.brand_id.label') }}</h3>
                        <p class="mt-1 text-gray-900">{{ $device->brand->name ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('devices.form.type_id.label') }}</h3>
                        <p class="mt-1 text-gray-900">{{ $device->type->name ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('devices.form.serial_number.label') }}</h3>
                        <p class="mt-1 text-gray-900">{{ $device->serial_number ?? 'N/A' }}</p>
                    </div>

                    <div>
                                                        <h3 class="text-sm font-medium text-gray-500">{{ __('devices.form.room_name.label') }}</h3>
                                                        <p class="mt-1 text-gray-900">{{ $device->room_name ?? 'N/A' }}</p>                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('devices.form.procurement_year.label') }}</h3>
                        <p class="mt-1 text-gray-900">{{ $device->procurement_year ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('devices.form.user_id.label') }}</h3>
                        <p class="mt-1 text-gray-900">{{ $device->pic->name ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">{{ __('devices.form.customer_id.label') }}</h3>
                        <p class="mt-1 text-gray-900">{{ $device->customer->name ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('devices.detail.cal_info') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="flex flex-col">
                            <h4 class="text-sm font-medium text-gray-500">{{ __('devices.form.calibration_date.label') }}</h4>
                            <p class="mt-1 text-gray-900">{{ $device->calibration_date ? \Carbon\Carbon::parse($device->calibration_date)->format('d M Y') : 'N/A' }}</p>
                        </div>

                        <div class="flex flex-col">
                            <h4 class="text-sm font-medium text-gray-500">{{ __('devices.form.next_calibration_date.label') }}</h4>
                            <p class="mt-1 text-gray-900">{{ $device->next_calibration_date ? \Carbon\Carbon::parse($device->next_calibration_date)->format('d M Y') : 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <h4 class="text-sm font-medium text-gray-500">{{ __('devices.form.cert_number.label') }}</h4>
                        @if($device->cert_number)
                            <a href="{{ route('certificate.download', ['cert_number' => $device->cert_number]) }}"
                               class="mt-1 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150 w-fit">
                               <i class="fas fa-download mr-2"></i>
                                {{ __('devices.detail.download_certificate') }}
                            </a>
                        @else
                            <p class="mt-1 text-gray-900">{{ __('devices.detail.cert_not_available') }}</p>
                        @endif
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500">{{ __('devices.form.notes.label') }}</h3>
                    <p class="mt-1 text-gray-900">{{ $device->notes ?? __('devices.form.notes.empty') }}</p>
                </div>
            </div> <!-- Close device details card -->
        </div> <!-- Close right column -->
    </div> <!-- Close left column -->
</div> <!-- Close main flex container -->
</div> <!-- Close main wrapper -->
