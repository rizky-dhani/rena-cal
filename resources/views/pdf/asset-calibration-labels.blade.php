<!DOCTYPE html>
<html>
<head>
    <title>Asset Calibration Labels</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 10px;
            background-color: #fff;
        }
        .labels-container {
            width: 100%;
        }
        .label-wrapper {
            margin-bottom: 10px;
            page-break-inside: avoid;
            display: inline-block;
            vertical-align: top;
        }

        /* Base Label Style */
        .label-card {
            border: 2px solid #000;
            background-color: #fff;
            overflow: hidden;
            box-sizing: border-box;
            border-collapse: collapse;
            width: 100%;
            height: 100%;
        }

        /* Size Variants (applied to the wrapper and table) */
        .size-v3 { width: 5cm; height: 3cm; }
        .size-v4 { width: 3cm; height: 2cm; }

        /* Content Layout */
        .logo-row {
            height: 40px;
        }
        .logo-cell {
            padding: 5px;
            border-bottom: 1px solid #000;
            vertical-align: middle;
        }
        .content-cell {
            vertical-align: middle;
            padding: 0;
        }
        .label-content-inner-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .barcode-col {
            vertical-align: middle;
            text-align: center;
            padding: 2px 4px 2px 0px;
            overflow: hidden;
        }
        .info-col {
            vertical-align: middle;
            padding: 5px;
            overflow: hidden;
        }

        /* Size-specific column widths */
        .size-v3 .info-col { width: 75%; }
        .size-v3 .barcode-col { width: 25%; }
        .size-v4 .info-col { width: 73%; }
        .size-v4 .barcode-col { width: 27%; }

        .logo-img {
            height: 25px;
            width: auto;
            max-width: 100%;
            vertical-align: middle;
        }
        .company-info {
            display: none;
        }

        /* Info Section */
        .info-row, .date-section {
            margin-bottom: 1px;
            font-size: 0;
            white-space: nowrap;
        }
        .info-label, .date-label {
            font-weight: bold;
            display: inline-block;
            vertical-align: middle;
            width: 60px;
            line-height: 1.1;
            font-size: 7px;
        }
        .info-colon, .date-colon {
            display: inline-block;
            vertical-align: middle;
            font-size: 8px;
            margin-right: 2px;
            font-weight: bold;
        }
        .info-value {
            display: inline-block;
            vertical-align: middle;
            white-space: nowrap;
            font-size: 7px;
        }

        /* Date Boxes Section */
        .date-section {
            margin-top: 2px;
        }
        .date-boxes {
            display: inline-block;
            vertical-align: middle;
            line-height: 1; /* Reset line height for boxes */
        }
        .date-box {
            display: inline-block;
            border: 1px solid #000;
            width: 14px;
            height: 12px;
            text-align: center;
            font-size: 8px;
            line-height: 11px; /* Slightly less than height to center text vertically */
            margin-right: 1px;
            vertical-align: middle;
        }
        .date-year {
            width: 28px;
        }
        .date-separator {
            display: inline-block;
            font-size: 8px;
            vertical-align: middle;
            margin-right: 1px;
        }

        /* Status Bar Row */
        .status-bar-row {
            height: 20px;
        }
        .status-bar-cell {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            vertical-align: middle;
            border-top: 1px solid #000;
        }
        .status-laik {
            background-color: #79d248; /* Green */
            color: #ffffff;
        }
        .status-tidak-laik {
            background-color: #ff0000; /* Red */
            color: #ffffff;
        }

        /* V3 Specific Scaling */
        .size-v3 .logo-row { height: 30px; }
        .size-v3 .info-label, .size-v3 .date-label { width: 40px; font-size: 5.5px; white-space: normal; }
        .size-v3 .barcode-col { padding: 0px 10px 0px 0px; }
        .size-v3 .info-value { font-size: 5.5px; }
        /*.size-v3 .date-colon { font-size: 5.5px; font-weight: bold; }*/
        .size-v3 .date-box { width: 12px; height: 10px; font-size: 6px; line-height: 10px; }
        .size-v3 .date-year { width: 22px; }
        .size-v3 .status-bar-cell { font-size: 9px; }

        /* V4 Specific Scaling */
        .size-v4 .logo-row { height: 12px; }
        .size-v4 .logo-cell { padding: 2px 5px 0px 5px; }
        .size-v4 .status-bar-row { height: 10px; }
        .size-v4 .info-section { display: none; }
        .size-v4 .info-section-v4 { margin-bottom: 1px; }
        .size-v4 .info-section-v4 .info-label { font-size: 3px; width: auto; min-width: 25px; white-space: nowrap; vertical-align: middle; }
        .size-v4 .info-section-v4 .info-colon { font-size: 3px; vertical-align: middle; font-weight: bold; }
        .size-v4 .info-section-v4 .info-value { font-size: 3px; vertical-align: middle; }
        .size-v4 .date-section { margin-top: 5px; }
        .size-v4 .date-label { font-size: 3px; width: auto; min-width: 20px; white-space: nowrap; vertical-align: middle; }
        .size-v4 .date-colon { font-size: 3px; vertical-align: middle; font-weight: bold; }
        .size-v4 .date-box { width: 8px; height: 6px; font-size: 5px; line-height: 6px; vertical-align: middle; }
        .size-v4 .date-year { width: 13px; }
        .size-v4 .date-separator { font-size: 4.5px; }
        .size-v4 .logo-img { height: 16px; }
        .size-v4 .status-bar-cell { font-size: 7px; }
        .size-v4 .barcode-col { padding: 2px 4px 2px 2px; }
        .size-v4 .barcode-col img { width: 38px !important; }

        /* Barcode Images Scaling */
        .barcode-col img {
            max-width: 100%;
            height: auto;
        }
        .size-v3 .barcode-col img { width: 38px; }

        .device-number {
            font-size: 6px;
            font-weight: bold;
            margin-top: 1px;
            text-align: center;
        }

        .size-v4 .device-number {
            font-size: 3px;
        }

    </style>
</head>
<body>
    <div class="labels-container">
        @foreach($assets as $asset)
            <div class="label-wrapper size-{{ $size ?? 'v3' }}">
                <table class="label-card">
                    <tr class="logo-row">
                        <td class="logo-cell" colspan="2">
                            <img src="{{ public_path('assets/images/logos/logo_rena_long.png') }}" class="logo-img" alt="Logo">
                        </td>
                    </tr>
                    <tr>
                        <td class="content-cell" colspan="2">
                            <table class="label-content-inner-table">
                                <tr>
                                    <!-- Info Column -->
                                    <td class="info-col">
                                        <div class="info-section">
                                            <div class="info-row">
                                                <span class="info-label">Nama Alat</span>
                                                <span class="info-colon">:</span>
                                                <span class="info-value">{{ $asset->deviceName?->name }}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">No. Seri</span>
                                                <span class="info-colon">:</span>
                                                <span class="info-value">{{ $asset->serial_number }}</span>
                                            </div>
                                        </div>

                                        @if(($size ?? 'v3') === 'v4')
                                        <div class="info-section-v4">
                                            <div class="info-row">
                                                <span class="info-label">Nama Alat</span>
                                                <span class="info-colon">:</span>
                                                <span class="info-value">{{ $asset->deviceName?->name }}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">No. Seri</span>
                                                <span class="info-colon">:</span>
                                                <span class="info-value">{{ $asset->serial_number }}</span>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="date-section">
                                            <span class="date-label">Tgl<br>Kalibrasi</span>
                                            <span class="date-colon">:</span>
                                            <div class="date-boxes">
                                                @php
                                                    $calDate = $asset->calibration_date ? \Carbon\Carbon::parse($asset->calibration_date) : null;
                                                @endphp
                                                <div class="date-box">{{ $calDate ? $calDate->format('d') : '' }}</div>
                                                <span class="date-separator">-</span>
                                                <div class="date-box">{{ $calDate ? $calDate->format('m') : '' }}</div>
                                                <span class="date-separator">-</span>
                                                <div class="date-box date-year">{{ $calDate ? $calDate->format('Y') : '' }}</div>
                                            </div>
                                        </div>

                                        @if($asset->result !== 'Tidak Laik Pakai')
                                        <div class="date-section">
                                            <span class="date-label">Kalibrasi<br>Selanjutnya</span>
                                            <span class="date-colon">:</span>
                                            <div class="date-boxes">
                                                @php
                                                    $nextDate = $asset->next_calibration_date ? \Carbon\Carbon::parse($asset->next_calibration_date) : null;
                                                @endphp
                                                <div class="date-box">{{ $nextDate ? $nextDate->format('d') : '' }}</div>
                                                <span class="date-separator">-</span>
                                                <div class="date-box">{{ $nextDate ? $nextDate->format('m') : '' }}</div>
                                                <span class="date-separator">-</span>
                                                <div class="date-box date-year">{{ $nextDate ? $nextDate->format('Y') : '' }}</div>
                                            </div>
                                        </div>
                                        @endif
                                    </td>

                                    <!-- Barcode Column -->
                                    <td class="barcode-col">
                                        @if($asset->barcode)
                                            <img src="{{ public_path('storage/' . $asset->barcode) }}" alt="Barcode">
                                            <div class="device-number">{{ $asset->device_number }}</div>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="status-bar-row">
                        <td class="status-bar-cell {{ $asset->result === 'Tidak Laik Pakai' ? 'status-tidak-laik' : 'status-laik' }}" colspan="2">
                            {{ strtoupper($asset->result ?? 'Laik Pakai') }}
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
    </div>
</body>
</html>
