# Design: Calibration Label Templates

## Overview
We will implement a versatile PDF template in Laravel using DomPDF. The template will be capable of rendering calibration labels in four different physical sizes while maintaining the design integrity of `label.png`.

## Template Architecture
The template `resources/views/pdf/asset-calibration-labels.blade.php` will:
1.  Accept a collection of `$assets` (devices).
2.  Accept a `$size` parameter (e.g., 'large', 'medium', 'small', 'tiny' or explicit dimensions).
3.  Use a shared CSS base for the label layout (Logo, Nama Alat, Nomor Seri, etc.).
4.  Apply size-specific CSS variables or classes to adjust font sizes, margins, and physical dimensions (`width` and `height` in `cm`).

## Visual Recreation
To ensure the best print quality, we will recreate the label design using HTML/CSS instead of just using a background image.
- **Top Section**: Logo and company information.
- **Barcode Column**: A vertical column on one side (likely left or right) to display the device's QR code/barcode.
- **Middle Section**: Key-value pairs for device details (Nama Alat, Nomor Seri).
- **Date Section**: Triple-box layout for day, month, and year for both calibration dates.
- **Bottom Section**: A green bar with the text "LAIK PAKAI".

## Dimensions Mapping
| Name | Width | Height |
| :--- | :--- | :--- |
| Version 1 | 7.0 cm | 5.0 cm |
| Version 2 | 6.0 cm | 4.0 cm |
| Version 3 | 5.0 cm | 3.0 cm |
| Version 4 | 3.0 cm | 1.5 cm |

## Technical Implementation Details
- **DomPDF Compatibility**: Use table-based layouts where CSS flexbox/grid might fail in older DomPDF versions if necessary, but try to use modern CSS first and fall back to tables for alignment.
- **Fonts**: Use standard sans-serif fonts compatible with DomPDF.
- **Page Breaks**: Ensure labels don't split across pages using `page-break-inside: avoid`.
