# Specification: Excel Export for Devices

## Overview
This track implements a robust Excel export feature for the Device resource in the Filament dashboard. It provides Super Admins, Admins, and Hospital Admins the flexibility to export all visible records, selected records, or a specific subset based on date ranges.

## Functional Requirements
- **Target Audience:** Restricted to users with 'Super Admin', 'Admin', and 'Hospital Admin' roles.
- **Data Scoping:** 
    - **Super Admin/Admin:** Can export any/all records across the system.
    - **Hospital Admin:** Can ONLY export records belonging to their specific customer organization (matching their existing dashboard view).
- **Export Actions:**
    - **Header Action:** Located on the Device list page. Opens a modal with options:
        - **Export Type:** "All Records" or "Date Range".
        - **Date Field Selection:** "Calibration Date" or "Next Calibration Date".
        - **Date Range Picker:** Start and End dates (enabled if "Date Range" is selected).
    - **Bulk Action:** Export specifically selected records from the table.
- **Data Columns:**
    - **Basic Info:** ID Perangkat, Nama Perangkat, Nomor Seri, Merek, Tipe.
    - **Service Info:** Tanggal Kalibrasi, Tanggal Kalibrasi Selanjutnya, Nomor Sertifikat, Hasil (Laik/Tidak).
    - **Ownership & Location:** Nama Pelanggan, Lokasi, Ruangan, Penanggung Jawab (PIC).

## Technical Requirements
- **Library:** Use `pxlrbt/filament-excel`.
- **Implementation:**
    - Use `ExportAction` and `BulkAction` from `pxlrbt/filament-excel`.
    - Implement conditional visibility for the actions based on user roles.
    - Integrate the table's existing query scoping (for Hospital Admins) into the export process.
- **Localization:** Ensure all column headers and form labels are in Bahasa Indonesia.

## Acceptance Criteria
- Super Admins, Admins, and Hospital Admins can see the "Export Excel" buttons.
- Technicians **cannot** see the export actions.
- Hospital Admins can only export data for their own devices.
- The Header Action correctly filters data based on the selected date field and range.
- The Bulk Action correctly exports only the selected records.
- The generated Excel file contains all required columns with localized headers.
