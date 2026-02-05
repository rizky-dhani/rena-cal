# Tasks: Automated QR Code Cleanup

- [x] Implement `deleted` event hook in `Device.php` model.
- [x] Refactor `DeleteAction` in `DevicesTable.php` to rely on model events.
- [x] Refactor `DeleteBulkAction` in `DevicesTable.php` to rely on model events.
- [x] Verify that deleting a device (individually or bulk) removes the file from `storage/app/public/qrcodes/`.
