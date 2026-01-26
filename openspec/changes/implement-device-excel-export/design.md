# Design: Device Excel Export

## Architecture
The export functionality will be integrated into the Filament resource using the `pxlrbt/filament-excel` plugin.

### Custom Export Class
We will define a custom `DeviceExport` class (extending `pxlrbt\FilamentExcel\Exports\ExcelExport`) to:
- Map specific Eloquent attributes/relationships to Excel columns.
- Use `lang/id/devices.php` for header translations.
- Format dates correctly.

### Filtering Logic
The Header Action will use a Filament Modal with a custom form:
- `export_type`: radio/select (All / Date Range).
- `date_field`: select (calibration_date / next_calibration_date).
- `date_range`: DateRangePicker (visible when export_type is Date Range).

### Visibility & Scoping
- Actions will be hidden for the 'Technician' role.
- Filament's built-in query scoping (already implemented in `DeviceResource` or `DevicesTable`) will automatically apply to the export, ensuring Hospital Admins only export authorized data.

### Localization
New translation keys will be added to `lang/id/devices.php` and `lang/en/devices.php` to support the export interface.
