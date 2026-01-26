# Device Import Design Document

## 1. Goal
To enable bulk import of device data into the system via an Excel (`.xlsx`) file, enhancing data entry efficiency and reducing manual effort.

## 2. Architecture
The Device Import feature will integrate with the existing Laravel application using the following components:

*   **Frontend:** FilamentPHP will provide the user interface for uploading the Excel file. A dedicated action or page within the `DeviceResource` will handle the file upload.
*   **Backend:**
    *   **Laravel Excel (Maatwebsite/Laravel-Excel):** This package will be used for parsing the incoming `.xlsx` files. The `ToModel` concern will facilitate direct mapping to the `Device` Eloquent model.
    *   **`DeviceImport` Class:** A new import class will encapsulate the logic for reading Excel rows, performing data validation using the `WithValidation` concern, and creating or updating `Device` model instances.
    *   **`App\Models\Device`:** The existing `Device` model will be used, and its fillable properties and validation rules will be respected during the import.
    *   **Database:** Imported data will be persisted in the `devices` table.

## 3. Data Flow
1.  User navigates to the Device management section in Filament.
2.  User clicks on an "Import Devices" action/button.
3.  A modal or page presents a file upload input.
4.  User selects a `device_template.xlsx` file and uploads it.
5.  Filament handles the file upload to the backend.
6.  The backend (via Laravel Excel and `DeviceImport`) reads the `.xlsx` file row by row.
7.  For each row:
    *   Data is validated against predefined rules in `DeviceImport`.
    *   If valid, a new `Device` model instance is created or an existing one is updated.
    *   If invalid, the error is recorded (e.g., row number, error message).
8.  Upon completion, a Filament notification is displayed to the user summarizing the import (e.g., number of successful imports, number of failures, and details of failures).

## 4. Error Handling
*   **Validation Errors:** The `WithValidation` concern in the `DeviceImport` class will be used to define rules. Errors will be collected and presented to the user, possibly grouped by row number, ensuring they can correct and re-import the problematic data.
*   **File Errors:** Issues like incorrect file format or unreadable files will be caught at the upload stage and reported.
*   **Database Errors:** Any database-related issues during model creation/update will be caught and reported.

## 5. Security Considerations
*   **File Upload Validation:** Ensure that only allowed file types (`.xlsx`) are uploaded.
*   **Data Validation:** Strict validation of all incoming data from the Excel file to prevent malicious or malformed data from entering the database.
*   **Authorization:** Ensure that only authorized users (e.g., administrators) can access the device import functionality. Filament's built-in authorization features will be leveraged.

## 6. Open Questions / Future Enhancements
*   Should the import run synchronously or asynchronously (e.g., using Laravel Queues for large files)? Initial implementation will likely be synchronous, with asynchronous processing as a potential future enhancement.
*   Consider a "dry run" option to preview import changes without committing to the database.
*   Support for updating existing devices based on a unique identifier in the Excel file (e.g., `device_number`). This will be part of the initial implementation.
*   Internationalization of error messages and column headings.

## 7. Dependencies
*   Maatwebsite/Laravel-Excel package.
*   FilamentPHP for the UI.

## 8. Inferred Schema from `device_template.xlsx` (based on `DeviceExport.php`)

The import expects the following columns, corresponding to the `Device` model attributes:

*   `deviceId`
*   `device_number`
*   `deviceName.name`
*   `serial_number`
*   `brand.name`
*   `type.name`
*   `calibration_date`
*   `next_calibration_date`
*   `cert_number`
*   `result`
*   `customer.name`
*   `room_name`
*   `pic.name`
