## ADDED Requirements

### Requirement: REQ-1: Role-Based Export Access
The system SHALL restrict Excel export functionality to Super Admin, Admin, and Hospital Admin roles.

#### Scenario: Unauthorized Access
- **WHEN** user with 'Technician' role views the Devices list page
- **THEN** they SHOULD NOT see any export-related buttons

#### Scenario: Authorized Access
- **WHEN** user with 'Hospital Admin' role views the Devices list page
- **THEN** they SHALL see the "Export" button in the header and bulk actions

### Requirement: REQ-2: Hospital Admin Data Scoping
Exports initiated by a Hospital Admin MUST only contain records belonging to their customer organization.

#### Scenario: Scoped Export
- **WHEN** a 'Hospital Admin' for 'Customer A' performs an export
- **THEN** the resulting file SHALL only contain devices where `customer_id` belongs to 'Customer A'

### Requirement: REQ-3: Date Range Filtering
The header export action SHALL allow filtering by calibration dates using a date range picker.

#### Scenario: Date Range Export
- **WHEN** an 'Admin' selects "Date Range" export with "Calibration Date" field
- **AND** specifies a range from 2025-01-01 to 2025-03-31
- **THEN** the exported file SHALL only contain devices calibrated within that period