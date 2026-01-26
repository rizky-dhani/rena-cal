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
        .size-v1 { width: 7cm; height: 5cm; }
        .size-v2 { width: 6cm; height: 4cm; }
        .size-v3 { width: 5cm; height: 3cm; }
        .size-v4 { width: 3cm; height: 1.5cm; }

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
        }
        .barcode-col {
            vertical-align: middle;
            text-align: center;
            border-left: 1px solid #000;
            padding: 2px 5px;
        }
        .info-col {
            vertical-align: middle;
            padding: 5px;
        }

        /* Size-specific column widths */
        .size-v1 .barcode-col { width: 1.6cm; }
        .size-v2 .barcode-col { width: 1.4cm; }
        .size-v3 .barcode-col { width: 1.1cm; }
        .size-v4 .barcode-col { width: 0.8cm; }

        .logo-img {
            height: 30px;
            width: auto;
            max-width: 100%;
            vertical-align: middle;
        }
        .company-info {
            display: none;
        }

        /* Fields Section */
        .field-row {
            margin-bottom: 3px;
            font-size: 10px;
        }
        .field-label {
            font-weight: bold;
            display: inline-block;
            width: 80px;
        }
        .field-value {
            display: inline-block;
        }

        /* Date Boxes Section */
        .date-section {
            margin-top: 3px;
            font-size: 0;
        }
        .date-label {
            font-size: 8px;
            font-weight: bold;
            display: inline-block;
            vertical-align: middle;
            width: 80px;
        }
        .date-colon {
            display: inline-block;
            vertical-align: middle;
            font-size: 10px;
            margin-right: 2px;
        }
        .date-boxes {
            display: inline-block;
            vertical-align: middle;
        }
        .date-box {
            display: inline-block;
            border: 1px solid #000;
            width: 14px;
            height: 12px;
            text-align: center;
            font-size: 8px;
            line-height: 12px;
            margin-right: 1px;
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
            background-color: #79d248; /* Green from label.png */
            color: #000;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            vertical-align: middle;
            border-top: 1px solid #000;
        }

        /* V4 Specific Scaling */
        .size-v4 .logo-row { height: 20px; }
        .size-v4 .status-bar-row { height: 12px; }
        .size-v4 .field-label { width: 40px; font-size: 6px; }
        .size-v4 .field-value { font-size: 6px; }
        .size-v4 .date-label { font-size: 5px; width: 40px; }
        .size-v4 .date-colon { font-size: 6px; }
        .size-v4 .date-box { width: 10px; height: 8px; font-size: 5px; line-height: 8px; }
        .size-v4 .date-year { width: 16px; }
        .size-v4 .logo-img { height: 15px; }
        .size-v4 .status-bar-cell { font-size: 8px; }
        .size-v4 .barcode-col { padding: 2px 3px; width: 0.8cm; }
        .size-v4 .barcode-col img { width: 16px !important; }

        /* Barcode Images Scaling */
        .barcode-col img {
            max-width: 100%;
            height: auto;
        }
        .size-v1 .barcode-col img { width: 45px; }
        .size-v2 .barcode-col img { width: 36px; }
        .size-v3 .barcode-col img { width: 28px; }

    </style>
</head>
<body>
    <div class="labels-container">
        @foreach($assets as $asset)
            <div class="label-wrapper size-{{ $size ?? 'v1' }}">
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
                                        <div class="field-row">
                                            <span class="field-label">Nama Alat</span>
                                            <span class="field-value">: {{ $asset->deviceName?->name }}</span>
                                        </div>
                                        <div class="field-row">
                                            <span class="field-label">Nomor Seri</span>
                                            <span class="field-value">: {{ $asset->serial_number }}</span>
                                        </div>

                                        <div class="date-section">
                                            <span class="date-label">Tanggal Kalibrasi</span>
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

                                        <div class="date-section">
                                            <span class="date-label">Kalibrasi Selanjutnya</span>
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
                                    </td>

                                    <!-- Barcode Column -->
                                    <td class="barcode-col">
                                        @if($asset->barcode)
                                            <img src="{{ public_path('storage/' . $asset->barcode) }}" alt="Barcode">
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr class="status-bar-row">
                        <td class="status-bar-cell" colspan="2">
                            LAIK PAKAI
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
    </div>
</body>
</html>
