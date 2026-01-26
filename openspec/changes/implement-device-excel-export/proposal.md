# Change: Implement Device Excel Export

## Why
Currently, technicians and admins have no way to export device data for offline reporting or external audits. Providing a robust Excel export feature improves operational efficiency and ensures compliance with asset tracking requirements.

## What Changes
- Install `pxlrbt/filament-excel` for Excel generation.
- Implement a custom `DeviceExport` class to handle column mapping and Indonesian translations.
- Add a Bulk Action for exporting selected records in `DevicesTable.php`.
- Add a Header Action for filtered exports (All/Date Range) in `ListDevices.php`.
- Add localization strings for export actions and headers in `lang/id/devices.php` and `lang/en/devices.php`.

## Impact
- Affected specs: `device-export` (new)
- Affected code: `app/Filament/Dashboard/Resources/Devices/`