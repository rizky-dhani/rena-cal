# Tasks: Chunk QR Code Generation

- [x] Refactor `GenerateMultipleQRCodesJob.php` to accept a `startNumber`.
- [x] Update `ListDevices.php` to calculate the starting sequence and dispatch jobs in chunks of 100.
- [x] Update `GenerateMultipleQRCodesJobTest.php` to verify chunked generation and sequence correctness.
- [x] Verify that 1,000 QR codes are correctly generated across 10 separate jobs.
