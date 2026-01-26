# Tasks: Implement Device Excel Export

## Phase 1: Environment and Core Logic
- [x] Install `pxlrbt/filament-excel` via composer. <!-- id: 1 -->
- [x] Add translation keys for export to `lang/id/devices.php` and `lang/en/devices.php`. <!-- id: 2 -->
- [x] Create a custom `DeviceExport` class with required column mappings and localized headers. <!-- id: 3 -->

## Phase 2: Action Integration
- [x] Add `BulkAction` to `DevicesTable.php`. <!-- id: 4 -->
- [x] Add `ExportAction` (Header Action) to `ListDevices.php`. <!-- id: 5 -->
- [x] Implement date range filtering in the Header Action. <!-- id: 6 -->
- [x] Restrict visibility of export actions to authorized roles. <!-- id: 7 -->

## Phase 3: Verification
- [x] Create a test to verify export accessibility for different roles. <!-- id: 8 -->
- [x] Create a test to verify data scoping for Hospital Admins. <!-- id: 9 -->
- [x] Create a test to verify date range filtering in the export. <!-- id: 10 -->
- [x] Run `vendor/bin/pint` to ensure code style compliance. <!-- id: 11 -->