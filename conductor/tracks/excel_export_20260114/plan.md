# Plan: Excel Export for Devices

## Phase 1: Environment and Core Logic
This phase focuses on installing the necessary tools and defining the basic export structure.

- [ ] **Task: Install and Configure Filament Excel**
    - [ ] Implement: Install `pxlrbt/filament-excel` via composer.
- [ ] **Task: Define Custom Export Class**
    - [ ] Write Tests: Verify the export class can be instantiated and has the correct column mappings.
    - [ ] Implement: Create a custom `ExcelExport` class for Devices with localized headers and selected columns.
- [ ] **Task: Localize Export Labels**
    - [ ] Write Tests: Ensure Indonesian translation keys for the export action and form fields exist.
    - [ ] Implement: Update `lang/id/devices.php` with the new export-related keys.
- [ ] **Task: Conductor - User Manual Verification 'Environment and Core Logic' (Protocol in workflow.md)**

## Phase 2: Action Integration and Filtering
This phase adds the export buttons to the dashboard and implements the date filtering logic.

- [ ] **Task: Implement Bulk Export Action**
    - [ ] Write Tests: Verify the bulk action is visible to authorized roles and hidden from Technicians.
    - [ ] Implement: Add `BulkAction` from the plugin to `DevicesTable.php`.
- [ ] **Task: Implement Header Export Action with Filtering**
    - [ ] Write Tests: Verify the header action modal shows correctly and captures date range inputs.
    - [ ] Implement: Add `ExportAction` to `ListDevices.php` or `DevicesTable.php` with a custom form for date selection.
- [ ] **Task: Verify Data Scoping for Hospital Admins**
    - [ ] Write Tests: Assert that a Hospital Admin's export only contains records from their organization.
    - [ ] Implement: Ensure the export action respects the table's base query scoping.
- [ ] **Task: Conductor - User Manual Verification 'Action Integration and Filtering' (Protocol in workflow.md)**

## Phase 3: Final Polish and Quality Gates
Final verification against project standards.

- [ ] **Task: Final Quality Gate Check**
    - [ ] Implement: Verify code coverage (80-90%), run Pint for formatting, and ensure all docstrings are complete.
- [ ] **Task: Conductor - User Manual Verification 'Final Polish' (Protocol in workflow.md)**
