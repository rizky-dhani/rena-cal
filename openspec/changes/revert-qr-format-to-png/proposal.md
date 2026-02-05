# Proposal: Revert QR Code Format to PNG

This proposal suggests reverting the QR code file format from SVG to PNG to optimize disk space, while maintaining the architectural performance improvements previously implemented.

## Problem
In a previous optimization, we switched from PNG to SVG. While SVG provides vector quality, the implementation in the `milon/barcode` library produces extremely large files (approx. 20KB per QR code) because it generates a separate `<rect>` element for every module in the matrix. In contrast, a PNG version of the same QR code is only ~400 bytes due to efficient binary compression of simple black-and-white patterns.

Generating 1,000 QR codes:
- SVG: ~20 MB
- PNG: ~0.4 MB

## Solution
1. **Revert to PNG**: Update all QR code generation logic to use the PNG format.
2. **Maintain Performance**: Retain the in-memory sequence management and bulk database insertion logic in `GenerateMultipleQRCodesJob.php` which solved the primary performance bottleneck (database overhead).
3. **Update Dependencies**: Ensure all services and import classes use the `.png` extension.

## Scope
- `app/Services/QRCodeService.php`: Revert to PNG generation.
- `app/Jobs/GenerateMultipleQRCodesJob.php`: Revert to PNG generation while keeping bulk logic.
- `app/Imports/DeviceImport.php`: Revert to PNG generation.
- `tests/Feature/DeviceImportTest.php`: Update assertions to expect `.png`.
- `tests/Feature/GenerateMultipleQRCodesJobTest.php`: Update assertions to expect `.png`.
