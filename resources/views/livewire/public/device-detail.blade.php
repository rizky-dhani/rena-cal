<div class="min-h-screen bg-[#0a0a0a] flex flex-col items-center justify-center p-4">
    <!-- Card Container -->
    <div class="w-full max-w-lg bg-[#141414] rounded-[2.5rem] border border-white/5 shadow-2xl overflow-hidden">
        
        <!-- Header / Device ID Style from Image -->
        <div class="px-8 pt-10 pb-4">
            <p class="text-gray-400 text-lg font-medium tracking-tight text-center">
                {{ $device->device_number ?? $device->deviceId }}
            </p>
            <div class="mt-4 border-b border-white/10"></div>
        </div>

        <!-- Details List -->
        <div class="px-8 py-6 space-y-4">
            @php
                $details = [
                    ['label' => 'Nama Faskes', 'value' => $device->customer->name ?? 'N/A'],
                    ['label' => 'Nama Alat', 'value' => $device->deviceName->name ?? 'N/A'],
                    ['label' => 'Merk/Pembuat', 'value' => $device->brand->name ?? 'N/A'],
                    ['label' => 'Model/Tipe', 'value' => $device->type->name ?? 'N/A'],
                    ['label' => 'Nomor Seri', 'value' => $device->serial_number ?? 'N/A'],
                    ['label' => 'Nama Ruangan', 'value' => $device->room_name ?? 'N/A'],
                    ['label' => 'Tanggal Kalibrasi', 'value' => $device->calibration_date ? \Carbon\Carbon::parse($device->calibration_date)->format('Y-m-d') : 'N/A'],
                    ['label' => 'Keterangan Hasil', 'value' => $device->result ?? 'N/A', 'is_status' => true],
                    ['label' => 'PIC', 'value' => $device->pic->name ?? 'N/A'],
                ];
            @endphp

            @foreach($details as $detail)
                <div class="flex items-start text-[15px]">
                    <span class="text-gray-100 w-36 shrink-0">{{ $detail['label'] }}</span>
                    <span class="text-gray-100 mr-4">:</span>
                    <span class="text-gray-100 font-medium break-words">
                        {{ $detail['value'] }}
                    </span>
                </div>
            @endforeach
        </div>

        <!-- Action Button Section -->
        <div class="mt-4 border-t border-white/10">
            @if($device->cert_number)
                <a href="{{ route('certificate.download', ['cert_number' => $device->cert_number]) }}"
                   class="flex items-center justify-center w-full py-5 bg-[#003cc2] hover:bg-[#0034a8] text-white font-semibold transition-colors duration-200">
                    Unduh Sertifikat Kalibrasi
                </a>
            @else
                <div class="flex items-center justify-center w-full py-5 bg-[#1a1a1a] text-gray-500 font-semibold cursor-not-allowed">
                    Sertifikat Belum Tersedia
                </div>
            @endif
        </div>
    </div>

    <!-- Optional Footer Logo -->
    <div class="mt-8 opacity-40 grayscale transition-all hover:opacity-100 hover:grayscale-0">
        <img src="{{ asset('assets/images/logos/Rena-Logo.webp') }}"
             alt="Rena Logo"
             class="h-10 object-contain">
    </div>
</div>
