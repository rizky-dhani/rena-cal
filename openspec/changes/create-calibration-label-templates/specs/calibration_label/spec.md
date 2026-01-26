# Spec Delta: Calibration Label Template

## ADDED Requirements

### Requirement: [REQ-001] Layout Fidelity
The template MUST visually match the provided `label.png` design, including company branding, field labels in Indonesian, and the "LAIK PAKAI" status bar.

#### Scenario: [SCN-001] Render Label Layout
- **Given** a device model.
- **When** rendering the label.
- **Then** the company info, fields, and status bar should be correctly positioned.

### Requirement: [REQ-002] Multi-Size Support
The template MUST support four distinct size variants using CSS:
- **v1**: 7cm width x 5cm height
- **v2**: 6cm width x 4cm height
- **v3**: 5cm width x 3cm height
- **v4**: 3cm width x 1.5cm height

#### Scenario: [SCN-002] Render Large Label
- **Given** a collection of devices.
- **When** the template is rendered with `v1` size.
- **Then** each label should occupy exactly 7cm x 5cm on the page.

#### Scenario: [SCN-003] Render Tiny Label
- **Given** a collection of devices.
- **When** the template is rendered with `v4` size.
- **Then** the font sizes and logo should scale down proportionally to fit the 3cm x 1.5cm area.

### Requirement: [REQ-003] Data Integration
The template MUST correctly map fields from the `Device` model:
- `Nama Alat` -> `deviceName.name`
- `Nomor Seri` -> `serial_number`
- `Tanggal Kalibrasi` -> `calibration_date` (formatted as DD - MM - YYYY)
- `Kalibrasi Selanjutnya` -> `next_calibration_date` (formatted as DD - MM - YYYY)
- `Barcode/QR` -> `barcode` (rendered as an image)

#### Scenario: [SCN-004] Data Mapping Verification
- **Given** a device with name "ECG Monitor", serial "SN123", and a barcode path.
- **When** rendering the label.
- **Then** "ECG Monitor", "SN123", and the corresponding QR code/barcode MUST appear.
