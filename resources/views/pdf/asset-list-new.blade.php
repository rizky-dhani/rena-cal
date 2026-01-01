<!DOCTYPE html>
<html>

<head>
    <title>Assets List</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        /* CSS 2.1 Compatible Styles for Dompdf */
        @page {
            margin: 15px;
        }

        body {
            font-family: sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0;
        }

        /* Master layout table for the 3-column grid */
        .layout-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .layout-table td {
            padding: 5px;
            vertical-align: top;
            text-align: center;
        }

        .layout-table tr {
            page-break-inside: avoid;
        }

        /* The asset label container */
        .asset-label {
            width: 230px;
            border: 4px double #000000;
            background: #ffffff;
            margin: 0 auto 10px;
            overflow: hidden;
        }

        /* Internal table to split QR and Details */
        .label-inner-table {
            width: 100%;
            border-collapse: collapse;
        }

        .label-inner-table td {
            padding: 0;
            vertical-align: middle;
        }

        .qr-code-cell {
            width: 71px; /* 65px img + 3px padding x 2 */
            height: 75px; /* Fixed height for vertical centering */
            border-right: 1px solid #000000;
            text-align: center;
            line-height: 0;
            padding: 3px;
        }

        .qr-code-cell img {
            width: 65px;
            height: auto;
            display: inline-block;
        }

        .asset-details-cell {
            text-align: left;
            vertical-align: middle;
            height: 75px;
        }

        /* Sub-table for Logo and Code */
        .details-inner-table {
            width: 100%;
            height: 75px;
            border-collapse: collapse;
        }

        .rena-logo-row {
            height: 35px;
            border-bottom: 1px solid #000000;
            text-align: center;
            vertical-align: middle;
            line-height: 0;
        }

        .rena-logo-row img {
            width: 50px;
            height: auto;
            display: inline-block;
        }

        .asset-code-row {
            height: 40px;
            text-align: center;
            vertical-align: middle;
        }

        .asset-code {
            font-size: 12px;
            font-weight: bold;
            color: #000000;
            margin: 0;
            line-height: 1.2;
        }
    </style>
</head>

<body>
    @php
$chunks = $assets->chunk(3);
    @endphp

    <div class="container">
        <table class="layout-table">
            @foreach($chunks as $chunk)
                <tr>
                    @foreach($chunk as $asset)
                        <td>
                            <div class="asset-label">
                                <table class="label-inner-table">
                                    <tr>
                                        <!-- Left side: QR Code -->
                                        <td class="qr-code-cell">
                                            <img src="{{ public_path('storage/' . $asset->barcode) }}" alt="QR Code">
                                        </td>
                                        <!-- Right side: Details -->
                                        <td class="asset-details-cell">
                                            <table class="details-inner-table">
                                                <tr>
                                                    <td class="rena-logo-row">
                                                        <img src="{{ public_path('assets/images/logos/Rena-Logo.webp') }}" alt="Rena">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="asset-code-row">
                                                        <div class="asset-code">{{ $asset->device_number }}</div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    @endforeach
                    {{-- Fill empty cells if the chunk is less than 3 --}}
                    @for($i = $chunk->count(); $i < 3; $i++)
                        <td></td>
                    @endfor
                </tr>
            @endforeach
        </table>
    </div>
</body>

</html>
