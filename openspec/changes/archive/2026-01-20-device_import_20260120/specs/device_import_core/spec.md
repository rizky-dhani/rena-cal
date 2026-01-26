# Device Import Core Specification

## ADDED Requirements

### Requirement: User can upload a valid Excel file to import devices.
Users SHALL be able to upload an Excel file (`.xlsx`) containing device data to efficiently create new device records or update existing ones in bulk within the system.

#### Scenario: Successful Device Import
Given the user is an authenticated administrator
And an Excel file `device_template.xlsx` is prepared with valid device data
When the user uploads the `device_template.xlsx` file via the Filament interface
Then the system should successfully process the file
And create new Device records in the database for each valid row
And display a success notification to the user
And redirect the user to the Device listing page.

### Requirement: System MUST validate data from the uploaded Excel file.
The system MUST rigorously validate all data imported from the Excel file against predefined rules, ensuring data integrity by rejecting invalid entries and providing clear error reporting.

#### Scenario: Invalid Data in Excel File
Given the user is an authenticated administrator
And an Excel file `device_template.xlsx` contains invalid data (e.g., missing required fields, incorrect data types)
When the user uploads the `device_template.xlsx` file via the Filament interface
Then the system should accurately identify the invalid rows
And prevent the creation of Device records for those invalid rows
And display a comprehensive error notification to the user
And clearly list the problematic rows and the specific reasons for the validation failures.

### Requirement: Filament interface SHALL provide an option to import devices.
A user-friendly and intuitive interface within Filament SHALL be provided to allow authorized administrators to easily access and utilize the device import functionality.

#### Scenario: Accessing Import Feature
Given the user is an authenticated administrator
When the user navigates to the DeviceResource in Filament
Then an "Import Devices" action or button should be prominently visible
And clicking this action/button should present a file upload interface, enabling the selection of an `.xlsx` file.

### Requirement: System SHALL update existing device fields based on device_number.
When a device with the same `device_number` already exists in the database, the system SHALL update the existing device's fields with the new data from the imported Excel file, rather than creating a new record.

#### Scenario: Update Existing Device
Given a device with `device_number` 'DEV-001' already exists in the database
And the imported Excel file contains a row with `device_number` 'DEV-001' and updated information for other fields
When the user uploads the Excel file
Then the system SHALL locate the existing device 'DEV-001'
And update its fields with the data from the Excel row
And not create a new device record.

### Requirement: System SHALL skip processing rows based on device_number and field completion.
The system SHALL intelligently skip processing rows under specific conditions: if `device_number` is not provided in a row, or if a device with the given `device_number` exists and all its fields (excluding `device_number`) are already filled from the Excel row.

#### Scenario: Skip Row Due to Missing device_number
Given an Excel file contains a row where the `device_number` field is empty or not provided
When the user uploads the Excel file
Then the system SHALL skip processing this row
And proceed to the next row in the Excel file without generating an error for the skipped row.

#### Scenario: Skip Row Due to Already Filled Fields
Given a device with `device_number` 'DEV-002' exists in the database
And the imported Excel file contains a row for 'DEV-002' where all fields (excluding `device_number`) are identical to the existing device's data
When the user uploads the Excel file
Then the system SHALL identify that no changes are required for 'DEV-002'
And skip updating this device
And proceed to the next row in the Excel file.