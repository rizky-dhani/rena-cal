# Tasks: Optimize QR Code Generation

- [x] Update `QRCodeService.php` to support SVG generation and improved bulk methods.
- [x] Refactor `GenerateMultipleQRCodesJob.php` to use memory-based sequence management and bulk insert.
- [x] Update file extension handling in `ListDevices.php` or relevant views if they assume `.png`.
- [x] Add tests to verify the optimization and SVG output.
- [x] Verify the performance improvement with a batch of 500-1000 QR codes.
