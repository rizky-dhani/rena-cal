# Plan: Excel Export for Devices

## Phase 1: Environment and Core Logic
This phase focuses on installing the necessary tools and defining the basic export structure.

- [x] **Task: Install and Configure Filament Excel**
    - [x] Implement: Install `pxlrbt/filament-excel` via composer.
- [x] **Task: Define Custom Export Class**
    - [x] Write Tests: Verify the export class can be instantiated and has the correct column mappings.
    - [x] Implement: Create a custom `ExcelExport` class for Devices with localized headers and selected columns.
- [x] **Task: Localize Export Labels**
    - [x] Write Tests: Ensure Indonesian translation keys for the export action and form fields exist.
    - [x] Implement: Update `lang/id/devices.php` with the new export-related keys.
- [x] **Task: Conductor - User Manual Verification 'Environment and Core Logic' (Protocol in workflow.md)**

## Phase 2: Action Integration and Filtering
This phase adds the export buttons to the dashboard and implements the date filtering logic.

- [x] **Task: Implement Bulk Export Action**
    - [x] Write Tests: Verify the bulk action is visible to authorized roles and hidden from Technicians.
    - [x] Implement: Add `BulkAction` from the plugin to `DevicesTable.php`.
- [x] **Task: Implement Header Export Action with Filtering**
    - [x] Write Tests: Verify the header action modal shows correctly and captures date range inputs.
    - [x] Implement: Add `ExportAction` to `ListDevices.php` or `DevicesTable.php` with a custom form for date selection.
- [x] **Task: Verify Data Scoping for Hospital Admins**
    - [x] Write Tests: Assert that a Hospital Admin's export only contains records from their organization.
    - [x] Implement: Ensure the export action respects the table's base query scoping.
- [x] **Task: Conductor - User Manual Verification 'Action Integration and Filtering' (Protocol in workflow.md)**

## Phase 3: Final Polish and Quality Gates
Final verification against project standards.

- [x] **Task: Final Quality Gate Check**
    - [x] Implement: Verify code coverage (80-90%), run Pint for formatting, and ensure all docstrings are complete.
- [x] **Task: Conductor - User Manual Verification 'Final Polish' (Protocol in workflow.md)**