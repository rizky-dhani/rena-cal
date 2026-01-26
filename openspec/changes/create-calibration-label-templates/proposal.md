# Proposal: Calibration Label Templates

Create a new PDF template for calibration labels using `label.png` as a base, providing 4 size variants.

## Motivation
The client needs to print calibration labels in various sizes to fit different devices. The labels must follow a specific design (as seen in `label.png`) and include key device calibration data.

## Proposed Changes
1. **New Blade Template**: Create `resources/views/pdf/asset-calibration-labels.blade.php`.
2. **Support 4 Sizes**: Use CSS to define the dimensions for:
    - 5cm x 7cm
    - 4cm x 6cm
    - 3cm x 5cm
    - 1.5cm x 3cm
3. **Data Mapping**: Display device name, serial number, calibration date, and next calibration date on the labels.
4. **Barcode Integration**: Add a dedicated column beside the device details to display the device's QR code/barcode.
5. **Layout**: Recreate the `label.png` layout using CSS for high-quality PDF output, or use the image as a background if pixel-perfect recreation is requested (preferring CSS for scalability).

## Out of Scope
- Modifying the existing `qr-print` route logic (unless requested to integrate).
- UI changes to select these sizes in Filament (will be proposed separately if needed, but for now focusing on the template).
