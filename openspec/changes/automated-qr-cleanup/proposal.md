# Proposal: Automated QR Code Cleanup on Device Deletion

This proposal implements automated cleanup of QR code image files whenever a `Device` record is deleted from the system, ensuring storage integrity and preventing orphaned files.

## Problem
Currently, the logic for deleting associated QR code files is manually implemented in specific Filament table actions. This is fragile because:
1. Deletions performed outside of the specific Filament actions (e.g., via Tinker, API, or other parts of the admin panel) would leave orphaned files in storage.
2. It violates the DRY (Don't Repeat Yourself) principle by duplicating deletion logic in both individual and bulk actions.

## Solution
1. **Model-Level Event Hook**: Move the file deletion logic to the `deleted` Eloquent model event in `app/Models/Device.php`. This ensures the cleanup happens regardless of how the deletion is triggered.
2. **Filament Refactoring**: Simplify `DevicesTable.php` by removing manual `action()` closures for `DeleteAction` and `DeleteBulkAction`, allowing them to use the default Filament behavior which triggers the model events.

## Scope
- `app/Models/Device.php`: Add `deleted` hook to handle file removal.
- `app/Filament/Dashboard/Resources/Devices/Tables/DevicesTable.php`: Remove manual file deletion logic from table actions.
