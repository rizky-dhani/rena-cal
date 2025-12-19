<!DOCTYPE html>
<html>
<head>
    <title>Assets List</title>
    <style>
        /* CSS 2.1 compatible styles */
        body {
            background-color: #fff;
        }

        .container-fluid {
            width: 100%;
            padding-right: 12px; /* 0.75rem converted to pixels */
            padding-left: 12px;  /* 0.75rem converted to pixels */
            margin-right: auto;
            margin-left: auto;
        }

        .my-4 {
            margin-top: 24px; /* 1.5rem converted to pixels */
            margin-bottom: 24px; /* 1.5rem converted to pixels */
        }

        .row {
            margin-right: -12px; /* -0.75rem converted to pixels */
            margin-left: -12px;  /* -0.75rem converted to pixels */
        }

        .col-4 {
            width: 32%; /* Reduced to account for margins/borders */
            float: left;
            margin-right: 1.33333333%; /* Add margin between columns */
            box-sizing: border-box;
        }

        /* Clear for last item in each row - using CSS 2.1 compatible approach */
        .col-4-last {
            margin-right: 0 !important;
        }

        .mb-3 {
            margin-bottom: 16px; /* 1rem converted to pixels */
        }

        .mx-2 {
            margin-right: 8px; /* 0.5rem converted to pixels */
            margin-left: 8px;  /* 0.5rem converted to pixels */
        }

        .m-0 {
            margin: 0;
        }

        .ps-0 {
            padding-left: 0;
        }

        .pb-1 {
            padding-bottom: 4px; /* 0.25rem converted to pixels */
        }

        .mt-1 {
            margin-top: 4px; /* 0.25rem converted to pixels */
        }

        .border {
            border: 1px solid #dee2e6;
        }

        .border-end {
            border-right: 1px solid #dee2e6;
        }

        .border-dark {
            border-color: #212529;
        }

        .border-b-2 {
            border-bottom: 2px solid black;
        }

        .d-flex {
            display: inline-block;
        }

        .justify-content-center {
            text-align: center;
        }

        .justify-content-start {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .clear {
            clear: both;
        }

        /* Original styles without flexbox */
        .asset-label {
            max-width: 240px;
            min-width: 200px; /* Reduced min-width to allow for better resizing */
            border: 4px double #000;
            margin: 8px auto;
            background: #fff;
            width: 100%;
            display: table; /* Use table display instead of flex */
            table-layout: fixed; /* Ensures consistent column widths */
            box-sizing: border-box; /* Include padding/border in width calculation */
        }

        .qr-code-section {
            display: table-cell;
            width: 40%; /* Increased width to give more space for QR code */
            vertical-align: middle;
            border-right: 1px solid #dee2e6;
            text-align: center;
            padding: 3px;
            height: 80px; /* Fixed height to contain QR code properly */
        }

        .qr-code-container {
            width: 75px; /* Fixed width for QR container */
            height: 75px; /* Fixed height for QR container */
            text-align: center;
            line-height: 75px; /* Set line-height equal to height for vertical centering */
        }

        .qr-code-container img {
            vertical-align: middle; /* Align image in the middle */
        }

        .qr-code img {
            width: 40px; /* Reduced size */
            height: 40px; /* Fixed height to ensure square */
            display: inline; /* Keep inline to work with line-height vertical centering */
            margin: 0;
            max-width: 100%; /* Ensure it doesn't exceed container */
            max-height: 100%;
        }

        .asset-details {
            display: table-cell;
            width: 60%; /* Reduced to accommodate increased QR code width */
            vertical-align: top;
            padding-left: 6px;
            vertical-align: middle; /* Align middle to match QR code */
        }

        .rena-logo {
            width: 100%;
            text-align: center;
        }

        .rena-logo img {
            width: 50px; /* Reduced size to prevent overflow */
            height: auto;
            display: block;
            margin: 0 auto 2px auto;
            max-width: 100%;
        }

        .qr-code-container {
            text-align: center;
        }

        .rena-logo-full-width {
            width: 100%;
        }

        .asset-code {
            font-size: 12px;
            font-weight: bold;
            color: #000;
            word-wrap: break-word;
            text-align: center;
            padding: 8px 0; /* Add vertical padding for spacing */
        }

        .asset-code h6 {
            margin: 0;
            padding: 0;
            font-size: 14px;
            font-weight: bold;
            line-height: 1.4; /* Control line height for vertical centering */
        }

        .table-row {
            display: table;
            width: 100%;
        }

        .table-cell {
            display: table-cell;
        }

        /* Clear floats */
        .clearfix:after {
            content: ".";
            display: block;
            height: 0;
            clear: both;
            visibility: hidden;
        }
    </style>
</head>
<body>
    @php
        $chunks = $assets->chunk(3);
    @endphp
    <div class="container-fluid my-4">
        @foreach($chunks as $chunk)
            <div class="row mb-3 justify-content-start mx-2 clearfix">
                @foreach($chunk as $asset)
                    <div class="col-4 d-flex justify-content-center">
                        <div class="asset-label">
                            <div class="qr-code-section">
                                <div class="qr-code-container">
                                    <img src="{{ asset('storage/' . $asset->barcode) }}" alt="QR Code" style="width: 75px; height: 75px;">
                                </div>
                            </div>
                            <div class="asset-details ps-0">
                                <div class="rena-logo border-b-2 border-dark">
                                    <img src="{{ asset('assets/images/logos/Rena-Logo.webp') }}" alt="Rena" class="pb-1">
                                </div>
                                <div class="asset-code text-center">
                                    <h6 class="mt-1">{{ $asset->device_number }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @for($i = $chunk->count(); $i < 3; $i++)
                    <div class="col-4" style="width: 33.33333333%; float: left;"></div>
                @endfor
            </div>
            <div class="clear"></div> <!-- Clear the floats after each row -->
        @endforeach
    </div>
</body>
</html>
