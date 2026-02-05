# Spec Delta: Calibration Label Template

## MODIFIED Requirements

### Requirement: [REQ-001] Layout Fidelity
The template MUST visually match the approved `v1` design across all supported sizes, including company branding in a dedicated top row, field labels in Indonesian, a right-aligned barcode column with even padding, and the "LAIK PAKAI" status bar at the bottom.

#### Scenario: [SCN-001] Render Label Layout Consistency
- **Given** any supported size variant (`v1`, `v2`, `v3`, `v4`).
- **When** rendering the label.
- **Then** the logo MUST be in its own row at the top.
- **AND** the device details and barcode MUST be in a two-column row below the logo.
- **AND** the status bar MUST be at the bottom.

### Requirement: [REQ-002] Multi-Size Support
The template MUST support four distinct size variants with synchronized layouts:
- **v1**: 7cm width x 5cm height
- **v2**: 6cm width x 4cm height
- **v3**: 5cm width x 3cm height
- **v4**: 3cm width x 1.5cm height

#### Scenario: [SCN-002] Synchronized Scaling
- **Given** a collection of devices.
- **When** the template is rendered for each size.
- **Then** all sizes MUST maintain the same relative proportions and layout structure as `v1`.
